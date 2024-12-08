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
        $user = (new User())
            ->setFirstname($resourceOwner->getFirstname())
            ->setLastname($resourceOwner->getLastname())
            ->setEmail($resourceOwner->getEmail())
            ->setRoles(['ROLE_USER'])
            ->setGoogleAuthId($resourceOwner->getId())
            ->setEnabled(true)
        ;

        $repository->add($user, true);

        return $user;
    }

    public function update(ResourceOwnerInterface $resourceOwner, UserRepository $repository, User $user): User
    {
        $user->setGoogleAuthId($resourceOwner->getId());

        $repository->add($user, true);

        return $user;
    }
}
