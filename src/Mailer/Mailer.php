<?php

namespace App\Mailer;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;

final class Mailer
{
    public function __construct(
        private readonly string $contactEmail,
        private readonly string $siteName,
        private readonly string $adminEmail,
        private readonly MailerInterface $mailer,
    ) {
    }

    public function sendNewRecipeCommentToEnable(): void
    {
        $email = (new TemplatedEmail())
            ->from(new Address($this->contactEmail, $this->siteName))
            ->to($this->adminEmail)
            ->subject('Salt & Pepper - Un nouveau commentaire a été ajouté.')
            ->htmlTemplate('mailer/new_recipe_comment_to_enable.html.twig')
        ;

        $this->mailer->send($email);
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function sendPreventUserFromAccountRemovalForInactivity(string $firstname, string $lastname, string $email): void
    {
        $email = (new TemplatedEmail())
            ->from(new Address($this->contactEmail, $this->siteName))
            ->to($email)
            ->subject('Salt & Pepper - Votre compte sera supprimé dans 30 jours.')
            ->htmlTemplate('mailer/prevent_user_from_account_deletion_for_inactivity.html.twig')
            ->context([
                'firstname' => $firstname,
                'lastname' => $lastname,
            ])
        ;

        $this->mailer->send($email);
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function sendRemovedAccountForInactivity(string $firstname, string $lastname, string $email): void
    {
        $email = (new TemplatedEmail())
            ->from(new Address($this->contactEmail, $this->siteName))
            ->to($email)
            ->subject('Salt & Pepper - Suppression de votre compte')
            ->htmlTemplate('mailer/remove_user_for_inactivity.html.twig')
            ->context([
                'firstname' => $firstname,
                'lastname' => $lastname,
            ])
        ;

        $this->mailer->send($email);
    }

    /**
     * @param array<int, array<string, string>> $users
     *
     * @throws TransportExceptionInterface
     */
    public function sendReportRemovedAccountForInactivity(array $users): void
    {
        $email = (new TemplatedEmail())
            ->from(new Address($this->contactEmail, $this->siteName))
            ->to($this->adminEmail)
            ->subject('Salt & Pepper - Rapport : Suppression de compte pour cause d\'inactivité')
            ->htmlTemplate('mailer/report_remove_user_for_inactivity.html.twig')
            ->context([
                'users' => $users,
            ])
        ;

        $this->mailer->send($email);
    }
}
