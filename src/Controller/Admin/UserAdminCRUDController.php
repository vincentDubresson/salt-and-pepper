<?php

namespace App\Controller\Admin;

use App\Entity\User;
use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @extends CRUDController<User>
 */
class UserAdminCRUDController extends CRUDController
{
    public function deleteAction(Request $request): Response
    {
        /** @var User $requestedUser */
        $requestedUser = $this->assertObjectExists($request, true);

        if ($requestedUser->getId() === User::ADMIN_ID) {
            $this->addFlash('error', 'Vous ne pouvez pas supprimer cet utilisateur.');

            return $this->redirectTo($request, $requestedUser);
        }

        return parent::deleteAction($request);
    }
}
