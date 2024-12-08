<?php

namespace App\Controller\Legal;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;

class LegalController extends AbstractController
{
    #[Route('/conditions-generales-utilisation', name: 'app_legal_cgu')]
    public function cgu(): \Symfony\Component\HttpFoundation\Response
    {
        return $this->render('legal/cgu.html.twig');
    }
}
