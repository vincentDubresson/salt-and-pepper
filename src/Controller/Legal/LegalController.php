<?php

namespace App\Controller\Legal;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class LegalController extends AbstractController
{
    #[Route('/conditions-generales-utilisation', name: 'app_legal_cgu')]
    public function cgu(): Response
    {
        return $this->render('legal/cgu.html.twig');
    }

    #[Route('/politique-protection-donnees', name: 'app_legal_rgpd')]
    public function rgpd(): Response
    {
        // Todo : Commande de suppression de compte après 12 mois
        // Todo : EventListener pour log d'ip + user agent des connexions
        // Todo : EventListener pour log d'ip + user agent des demandes de réinitialisation de mdp
        // Todo : Permettre la suppression de son compte
        return $this->render('legal/rgpd.html.twig');
    }
}
