<?php

namespace App\EventListener;

use App\Entity\User;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

readonly class UserActivationListener
{
    public function __construct(
        private TokenStorageInterface $tokenStorage, // Injection de TokenStorageInterface
    ) {
    }

    public function onKernelRequest(RequestEvent $event): void
    {
        $request = $event->getRequest();
        $route = $request->attributes->get('_route');

        if (is_string($route) && str_starts_with($route, 'admin_app_')) {
            $token = $this->tokenStorage->getToken();

            // Vérifier si un utilisateur est connecté
            if ($token && $token->getUser() instanceof User) {
                /** @var User $user */
                $user = $token->getUser();

                if (!$user->isEnabled()) {
                    throw new AccessDeniedHttpException();
                }
            }
        }
    }
}
