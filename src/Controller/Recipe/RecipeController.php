<?php

namespace App\Controller\Recipe;

use App\Repository\RecipeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\ExpressionLanguage\Expression;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class RecipeController extends AbstractController
{
    #[Route('/recette-au-hasard', name: 'sap_random_recipe')]
    #[IsGranted(new Expression('is_granted("PUBLIC_ACCESS")'))]
    public function random(
        RecipeRepository $recipeRepository,
    ): Response {
        $randomRecipe = $recipeRepository->getRandomRecipe();

        // Todo: BreadCrumb

        return $this->render('recipe/recipe.html.twig', ['recipe' => $randomRecipe]);
    }
}
