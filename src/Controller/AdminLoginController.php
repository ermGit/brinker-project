<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

final class AdminLoginController extends AbstractController
{
    /*
    #[Route('/admin/login', name: 'app_admin_login')]
    public function index(): Response
    {
        return $this->render('admin_login/index.html.twig', [
            'controller_name' => 'AdminLoginController',
        ]);
    }
    */

    #[Route('/admin/login', name: 'app_admin_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // Get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // Last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('admin_login/login.html.twig', [
            'controller_name' => 'AdminLoginController',
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    #[Route('/admin/logout', name: 'app_admin_logout')]
    public function logout(): void
    {
        // Symfony handles this automatically
        throw new \LogicException('Logout is handled by Symfony firewall.');
    }
}
