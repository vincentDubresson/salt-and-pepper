<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\LoginFormType;
use App\Form\RegisterFormType;
use App\Service\SecurityService;
use http\Exception\InvalidArgumentException;
use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    public const SCOPES = [
        'google' => [],
    ];

    public const DUPLICATE_ENTRY_CODE = 1062;

    public function __construct(
        private readonly string $googleAuthRedirectUri,
    ) {
    }

    #[Route(path: '/se-connecter', name: 'app_security_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        $user = $this->getUser();

        if ($user instanceof User) {
            return $this->redirectToRoute('app_home');
        }
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        $form = $this->createForm(LoginFormType::class);

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
            'form' => $form,
        ]);
    }

    #[Route(path: '/logout', name: 'app_security_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    #[Route('/oauth/connect/{service}', name: 'auth_oauth_connect', methods: ['GET'])]
    public function connect(string $service, ClientRegistry $clientRegistry): RedirectResponse
    {
        if (!in_array($service, array_keys(self::SCOPES), true)) {
            throw $this->createNotFoundException();
        }

        return $clientRegistry
            ->getClient($service)
            ->redirect(self::SCOPES[$service], ['redirect_uri' => $this->googleAuthRedirectUri])
        ;

    }

    #[Route('/oauth/check/{service}', name: 'auth_oauth_check', methods: ['GET', 'POST'])]
    public function check(): Response
    {
        return new Response(status: 200);
    }

    #[Route(path: '/creer-mon-compte', name: 'app_security_register', methods: ['GET', 'POST'])]
    public function register(Request $request, SecurityService $securityService): Response
    {
        $form = $this->createForm(RegisterFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var array{
             *     firstname: string,
             *     lastname: string,
             *     email: string,
             *     rawPassword: array{first: string, second: string},
             *     _token: string
             * } $formData
             */
            $formData = $request->get('register_form');
            /** @var string $csrfToken */
            $csrfToken = $formData['_token'];

            if ($this->isCsrfTokenValid('register_form', $csrfToken)) {
                try {
                    $securityService->createUser($formData);
                    $this->addFlash('success', 'Votre compte est créé. Vous pouvez maintenant vous connecter.');

                    return $this->redirectToRoute('app_security_login');
                } catch (\Exception $e) {
                    if ($e->getCode() == self::DUPLICATE_ENTRY_CODE) {
                        $this->addFlash('error', 'Ce compte existe déjà.');
                    }
                }
            }

            throw new InvalidArgumentException();
        }

        return $this->render('security/register.html.twig', [
            'registerForm' => $form,
        ]);
    }
}
