<?php

namespace App\Mailer;

use Scheb\TwoFactorBundle\Mailer\AuthCodeMailerInterface;
use Scheb\TwoFactorBundle\Model\Email\TwoFactorInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;

class TwoFactorAuthCodeMailer implements AuthCodeMailerInterface
{
    public function __construct(private readonly MailerInterface $mailer)
    {
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function sendAuthCode(TwoFactorInterface $user): void
    {
        $authCode = $user->getEmailAuthCode();

        $email = (new TemplatedEmail())
            ->from(new Address('contact@vdub-dev.com', 'Salt and Pepper'))
            ->to((string) $user->getEmailAuthRecipient())
            ->subject('Double authentification')
            ->htmlTemplate('security/2fa_auth_email.html.twig')
            ->context([
                'authCode' => $authCode,
            ])
        ;

        $this->mailer->send($email);
    }
}
