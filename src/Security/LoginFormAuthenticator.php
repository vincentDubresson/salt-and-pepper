<?php

namespace App\Security;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;
use Symfony\Component\Security\Http\Authenticator\AbstractLoginFormAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\CsrfTokenBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\RememberMeBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\EntryPoint\AuthenticationEntryPointInterface;
use Symfony\Component\Security\Http\SecurityRequestAttributes;
use Symfony\Component\Security\Http\Util\TargetPathTrait;

class LoginFormAuthenticator extends AbstractLoginFormAuthenticator implements AuthenticationEntryPointInterface
{
    use TargetPathTrait;

    public const LOGIN_ROUTE = 'app_security_login';

    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly RouterInterface $router,
        private readonly LoggerInterface $loginLogger,
        private readonly EntityManagerInterface $entityManager,
    ) {
    }

    public function supports(Request $request): bool
    {
        return self::LOGIN_ROUTE === $request->attributes->get('_route')
            && $request->isMethod('POST');
    }

    public function authenticate(Request $request): Passport
    {
        $requestParams = $request->request->all();
        /** @var array<mixed> $loginForm */
        $loginForm = $requestParams['login_form'];
        $email = $loginForm['_username'];
        $password = $loginForm['_password'];

        $csrfToken = $request->request->get('_csrf_token');

        $ip = $request->getClientIp();
        $userAgent = $request->headers->get('User-Agent');

        if (!is_string($email) || !is_string($password) || !is_string($csrfToken)) {
            throw new UserNotFoundException();
        }

        $this->loginLogger->info('Authentication attempt', [
            'ip' => $ip,
            'email' => $email,
            'user_agent' => $userAgent,
        ]);

        return new Passport(
            new UserBadge($email, function ($userIdentifier) {
                // Todo : Ajouter ici les vérifications complémentaires sur les utilisateurs si besoin
                $user = $this->userRepository->findOneBy(['email' => $userIdentifier, 'enabled' => true]);

                if (!$user) {
                    throw new UserNotFoundException();
                }

                return $user;
            }),
            new PasswordCredentials($password),
            [
                new CsrfTokenBadge(
                    'authenticate',
                    $csrfToken
                ),
                new RememberMeBadge(),
            ]
        );
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        $this->updateLastConnectionAt($token);

        if ($target = $this->getTargetPath($request->getSession(), $firewallName)) {
            return new RedirectResponse($target);
        }

        /** @var Session $session */
        $session = $request->getSession();

        $flashBag = $session->getFlashBag();

        $flashBag->add('success', 'Authentification réussie.');

        /** @var ?string $redirectTo */
        $redirectTo = $session->get('redirect_to');

        if (!empty($redirectTo)) {
            $session->remove('redirect_to');

            return new RedirectResponse((string) $redirectTo);
        }

        return new RedirectResponse($this->router->generate('app_home'));
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): Response
    {
        $request->getSession()->set(SecurityRequestAttributes::AUTHENTICATION_ERROR, $exception);

        return new RedirectResponse(
            $this->router->generate('app_security_login')
        );
    }

    protected function getLoginUrl(Request $request): string
    {
        return $this->router->generate('app_security_login');
    }

    private function updateLastConnectionAt(TokenInterface $token): void
    {
        /** @var User $user */
        $user = $token->getUser();

        $user->setLastConnectionAt(new \DateTime());

        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }
}
