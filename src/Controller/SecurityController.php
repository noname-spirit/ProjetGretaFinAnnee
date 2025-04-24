<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Security;

class SecurityController extends AbstractController
{
    #[Route('/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // obtenir les erreurs de login s'il y en a
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error
        ]);
    }

    #[Route('/redirect-after-login', name: 'app_redirect_after_login')]
    public function redirectAfterLogin(Security $security): RedirectResponse
    {
        $user = $security->getUser();

        if ($user && in_array('ROLE_ADMIN', $user->getRoles())) {
            return $this->redirectToRoute('admin_dashboard');
        }

        return $this->redirectToRoute('homepage');
    }

    #[Route('/logout', name: 'app_logout')]
    public function logout(): void
    {
        // Ce contrôleur peut rester vide, Symfony intercepte la route.
    }
}
