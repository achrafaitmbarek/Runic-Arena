<?php

namespace App\Security;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Http\Authorization\AccessDeniedHandlerInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class AccessDeniedHandler implements AccessDeniedHandlerInterface
{
    public function __construct(
        private UrlGeneratorInterface $urlGenerator,
        private RequestStack $requestStack
    ) {}

    public function handle(Request $request, AccessDeniedException $accessDeniedException): Response
    {
        $this->requestStack->getSession()->getFlashBag()->add(
            'error',
            'Access Denied. You do not have permission to access this page.'
        );

        return new RedirectResponse($this->urlGenerator->generate('app_home'));
    }
}
