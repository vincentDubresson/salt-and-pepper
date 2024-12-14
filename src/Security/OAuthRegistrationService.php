<?php

namespace App\Security;

use App\Entity\User;
use App\Repository\UserRepository;
use League\OAuth2\Client\Provider\GoogleUser;
use League\OAuth2\Client\Provider\ResourceOwnerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

final readonly class OAuthRegistrationService
{
    public function __construct(private UserPasswordHasherInterface $passwordHasher)
    {
    }

    /**
     * @param GoogleUser $resourceOwner
     */
    public function persist(ResourceOwnerInterface $resourceOwner, UserRepository $repository): User
    {
        /** @var string $googleUserId */
        $googleUserId = $resourceOwner->getId();

        $user = new User();

        $hashedGoogleUserId = $this->passwordHasher->hashPassword($user, $googleUserId);

        $user
            ->setFirstname((string) $resourceOwner->getFirstname())
            ->setLastname((string) $resourceOwner->getLastname())
            ->setEmail((string) $resourceOwner->getEmail())
            ->setRoles(['ROLE_USER'])
            ->setGoogleAuthId($hashedGoogleUserId)
            ->setEnabled(true)
        ;

        $repository->add($user, true);

        return $user;
    }

    public function update(ResourceOwnerInterface $resourceOwner, UserRepository $repository, User $user): User
    {
        /** @var string $googleUserId */
        $googleUserId = $resourceOwner->getId();
        $hashedGoogleUserId = $this->passwordHasher->hashPassword($user, $googleUserId);

        $user->setGoogleAuthId($hashedGoogleUserId);

        $repository->add($user, true);

        return $user;
    }
}
