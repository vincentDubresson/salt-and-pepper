<?php

namespace App\Service;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

final readonly class SecurityService
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private UserPasswordHasherInterface $passwordHasher,
    ) {
    }

    /**
     * @param array{
     *     firstname: string,
     *     lastname: string,
     *     email: string,
     *     rawPassword: array{first: string, second: string},
     *     _token: string
     * } $registerFormData
     *
     * @throws \Exception
     */
    public function createUser(array $registerFormData): void
    {
        $firstName = $registerFormData['firstname'];
        $lastName = $registerFormData['lastname'];
        $email = $registerFormData['email'];
        $password = $registerFormData['rawPassword']['second'];

        $newUser = new User();

        $newUser
            ->setFirstName($firstName)
            ->setLastName($lastName)
            ->setEmail($email)
            ->setPassword($this->passwordHasher->hashPassword($newUser, $password))
            ->setRoles(['ROLE_USER'])
            ->setEnabled(true)
            ->setTrustedVersion(0)
        ;

        $this->entityManager->persist($newUser);
        $this->entityManager->flush();
    }
}
