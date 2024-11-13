<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        $this->addFlash('success', 'Yes !!!');
        $this->addFlash('success', 'Yes 2 !!!');
        $this->addFlash('error', 'No !!!');

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}
