<?php

namespace App\Security;

use App\Entity\User;
use App\Repository\UserRepository;
use League\OAuth2\Client\Provider\GoogleUser;
use League\OAuth2\Client\Provider\ResourceOwnerInterface;

final readonly class OAuthRegistrationService
{
    /**
     * @param GoogleUser $resourceOwner
     */
    public function persist(ResourceOwnerInterface $resourceOwner, UserRepository $repository): User
    {
        /** @var string $googleUserId */
        $googleUserId = $resourceOwner->getId();

        $user = (new User())
            ->setFirstname((string) $resourceOwner->getFirstname())
            ->setLastname((string) $resourceOwner->getLastname())
            ->setEmail((string) $resourceOwner->getEmail())
            ->setRoles(['ROLE_USER'])
            ->setGoogleAuthId($googleUserId)
            ->setEnabled(true)
        ;

        $repository->add($user, true);

        return $user;
    }

    public function update(ResourceOwnerInterface $resourceOwner, UserRepository $repository, User $user): User
    {
        /** @var string $googleUserId */
        $googleUserId = $resourceOwner->getId();

        $user->setGoogleAuthId($googleUserId);

        $repository->add($user, true);

        return $user;
    }
}
