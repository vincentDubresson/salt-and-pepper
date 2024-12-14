<?php

namespace App\EventListener;

use Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException;
use Sonata\AdminBundle\Exception\ModelManagerException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\Routing\RouterInterface;

class ExceptionListener
{
    private RouterInterface $router;
    private RequestStack $requestStack;

    public function __construct(RouterInterface $router, RequestStack $requestStack)
    {
        $this->router = $router;
        $this->requestStack = $requestStack;
    }

    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        if ($exception instanceof ModelManagerException) {
            $exception = $exception->getPrevious();

            if ($exception instanceof ForeignKeyConstraintViolationException) {
                $request = $this->requestStack->getCurrentRequest();
                if ($request instanceof Request) {
                    /** @var Session $session */
                    $session = $request->getSession();

                    $session->getFlashBag()->add(
                        'error',
                        "Cette donnée ne peut pas être supprimée car elle est liée à d'autres entités."
                    );
                }

                /** @var string $referer */
                $referer = $request ? $request->headers->get('referer') : $this->router->generate('app_home');
                $response = new RedirectResponse($referer);
                $event->setResponse($response);
            }
        }
    }
}
