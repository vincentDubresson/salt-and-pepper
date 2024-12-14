<?php

namespace App\Security;

use App\Entity\User;
use App\Repository\UserRepository;
use League\OAuth2\Client\Provider\GoogleUser;
use League\OAuth2\Client\Provider\ResourceOwnerInterface;
use Symfony\Component\PasswordHasher\Hasher\PasswordHasherFactory;
use Symfony\Component\Security\Core\Exception\AuthenticationException;

class GoogleAuthenticator extends AbstractOAuthAuthenticator
{
    protected string $serviceName = 'google';

    protected function getUserFromResourceOwner(ResourceOwnerInterface $resourceOwner, UserRepository $repository): ?User
    {
        if (!($resourceOwner instanceof GoogleUser)) {
            throw new \RuntimeException('expecting google user');
        }

        if (true !== ($resourceOwner->toArray()['email_verified'] ?? null)) {
            throw new AuthenticationException('email not verified');
        }

        $passwordHasherFactory = new PasswordHasherFactory([
            'common' => ['algorithm' => 'bcrypt'],
        ]);

        /** @var string $resourceOwnerGoogleId */
        $resourceOwnerGoogleId = $resourceOwner->getId();

        $hasher = $passwordHasherFactory->getPasswordHasher('common');

        $hashedGoogleUserId = $hasher->hash($resourceOwnerGoogleId);

        return $repository->findOneBy([
            'googleAuthId' => $hashedGoogleUserId,
            'email' => $resourceOwner->getEmail(),
        ]);
    }

    protected function getUserFromEmailOwner(ResourceOwnerInterface $resourceOwner, UserRepository $repository): ?User
    {
        if (!($resourceOwner instanceof GoogleUser)) {
            throw new \RuntimeException('expecting google user');
        }

        if (true !== ($resourceOwner->toArray()['email_verified'] ?? null)) {
            throw new AuthenticationException('email not verified');
        }

        return $repository->findOneBy([
            'email' => $resourceOwner->getEmail(),
        ]);
    }
}
