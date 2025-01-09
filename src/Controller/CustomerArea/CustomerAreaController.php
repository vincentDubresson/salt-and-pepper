<?php

namespace App\Controller\CustomerArea;

use App\Entity\User;
use App\Form\AccountFormType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\ExpressionLanguage\Expression;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/espace-client')]
#[IsGranted(new Expression('is_granted("ROLE_USER")'))]
class CustomerAreaController extends AbstractController
{
    #[Route('/mon-compte', name: 'app_customer_area_my_account', methods: ['GET', 'POST'])]
    public function myAccount(Request $request, UserRepository $userRepository): Response
    {
        /** @var User $user */
        $user = $this->getUser();

        $form = $this->createForm(AccountFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var User $user */
            $user = $form->getData();
            $userRepository->update($user);

            $this->addFlash('success', 'Votre compte a été mis à jour.');
        }

        return $this->render('customer_area/my_account.html.twig', [
            'myAccountForm' => $form,
        ]);
    }

    #[Route('/mes-recettes', name: 'app_customer_area_my_recipes')]
    public function myRecipes(): Response
    {
        return $this->render('customer_area/my_account.html.twig');
    }

    #[Route('/mes-recettes-favorites', name: 'app_customer_area_my_favorites')]
    public function myFavorites(): Response
    {
        return $this->render('customer_area/my_account.html.twig');
    }

    #[Route('/mes-commentaires', name: 'app_customer_area_my_comments')]
    public function myComments(): Response
    {
        return $this->render('customer_area/my_account.html.twig');
    }
}
