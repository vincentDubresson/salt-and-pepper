<?php

namespace App\Controller\Recipe;

use App\Entity\Recipe;
use App\Entity\RecipeUserFavorites;
use App\Entity\User;
use App\Mailer\Mailer;
use App\Repository\RecipeRepository;
use App\Repository\RecipesCommentsRepository;
use App\Repository\RecipeUserFavoritesRepository;
use App\Service\RecipeService;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Exception\ORMException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\ExpressionLanguage\Expression;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/recette')]
class RecipeController extends AbstractController
{
    #[Route('/{slug},{recipeId}', name: 'sap_detail_recipe')]
    #[IsGranted(new Expression('is_granted("PUBLIC_ACCESS")'))]
    public function recipe(
        string $slug,
        int $recipeId,
        RecipeRepository $recipeRepository,
        RecipeService $recipeService,
    ): Response {
        $recipe = $recipeRepository->findOneById($recipeId);

        if (!$recipe instanceof Recipe) {
            throw new NotFoundHttpException();
        }

        $recipeSlug = $recipe->getSlug();

        if ($recipeSlug !== $slug) {
            return $this->redirectToRoute('sap_detail_recipe', ['slug' => $recipeSlug, 'recipeId' => $recipe->getId()]);
        }

        $recipeService->incrementViews($recipe);

        return $this->render('recipe/recipe.html.twig', ['recipe' => $recipe]);
    }

    #[Route('/recette-au-hasard', name: 'sap_random_recipe')]
    #[IsGranted(new Expression('is_granted("PUBLIC_ACCESS")'))]
    public function random(
        RecipeRepository $recipeRepository,
        RecipeService $recipeService,
    ): Response {
        /** @var Recipe $randomRecipe */
        $randomRecipe = $recipeRepository->getRandomRecipe();

        $slug = $randomRecipe->getSlug();
        $id = $randomRecipe->getId();

        return $this->redirectToRoute('sap_detail_recipe', ['slug' => $slug, 'recipeId' => $id]);
    }

    /**
     * @throws ORMException
     */
    #[Route('/gestion-recette-favorites', name: 'sap_recipe_favorites', options: ['expose' => true], methods: ['POST'])]
    #[IsGranted(new Expression('is_granted("ROLE_USER")'))]
    public function manageFavorites(Request $request, EntityManagerInterface $em, RecipeUserFavoritesRepository $recipeUserFavoritesRepository): JsonResponse
    {

        $userId = $request->get('userId');
        $recipeId = $request->get('recipeId');
        $isLikedRecipe = $request->get('isLike');

        if (!is_numeric($userId) || !is_numeric($recipeId) || !is_numeric($isLikedRecipe)) {
            return new JsonResponse(false, Response::HTTP_BAD_REQUEST);
        }

        $user = $em->getReference(User::class, $userId);
        $recipe = $em->getReference(Recipe::class, $recipeId);

        if (!$user instanceof User || !$recipe instanceof Recipe) {
            return new JsonResponse(false, Response::HTTP_BAD_REQUEST);
        }

        $recipeFavorite = $recipeUserFavoritesRepository->findOneBy(['user' => $user, 'recipe' => $recipe]);

        if ($isLikedRecipe) {
            if ($recipeFavorite instanceof RecipeUserFavorites) {
                return new JsonResponse(false, Response::HTTP_BAD_REQUEST);
            }

            $recipeUserFavoritesRepository->addNew($user, $recipe);

            return new JsonResponse('Recette enregistrée dans vos favoris', Response::HTTP_OK);
        }

        if (!$recipeFavorite instanceof RecipeUserFavorites) {
            return new JsonResponse(false, Response::HTTP_BAD_REQUEST);
        }

        $recipeUserFavoritesRepository->remove($recipeFavorite);

        return new JsonResponse('Recette supprimée de vos favoris', Response::HTTP_OK);
    }

    /**
     * @throws ORMException
     */
    #[Route('/ajouter-commentaire', name: 'sap_recipe_add_comment', options: ['expose' => true], methods: ['POST'])]
    #[IsGranted(new Expression('is_granted("ROLE_USER")'))]
    public function addComment(
        Request $request,
        EntityManagerInterface $em,
        RecipesCommentsRepository $recipesCommentsRepository,
        Mailer $mailer,
    ): JsonResponse {
        /** @var User $user */
        $user = $this->getUser();
        $recipeId = $request->get('recipeId');
        /** @var string $recipeComment */
        $recipeComment = $request->get('recipeComment');

        if (!is_numeric($recipeId)) {
            return new JsonResponse(false, Response::HTTP_BAD_REQUEST);
        }

        $recipe = $em->getReference(Recipe::class, $recipeId);

        if (!$recipe instanceof Recipe) {
            return new JsonResponse(false, Response::HTTP_BAD_REQUEST);
        }

        try {
            $recipesCommentsRepository->addRecipeComment($recipe, $user, $recipeComment);
        } catch (\Exception $exception) {
            return new JsonResponse(false, Response::HTTP_BAD_REQUEST);
        }

        $mailer->sendNewRecipeCommentToEnable();

        return new JsonResponse(true, Response::HTTP_OK);
    }
}
