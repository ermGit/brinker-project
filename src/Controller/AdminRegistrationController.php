<?php

namespace App\Controller;

use App\Entity\Admin;
use App\Form\AdminType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
//use Symfony\Component\Routing\Attribute\Route;

final class AdminRegistrationController extends AbstractController
{
    #[Route('/admin/registration', name: 'app_admin_registration')]
    public function index(): Response
    {
        return $this->render('admin_registration/index.html.twig', [
            'controller_name' => 'AdminRegistrationController',
        ]);
    }

    #[Route('/admin/register', name: 'admin_register')]
    public function register(
        Request $request,
        EntityManagerInterface $entityManager,
        UserPasswordHasherInterface $passwordEncoder
    ): Response
    {
        $admin = new Admin();
        $form = $this->createForm(AdminType::class, $admin);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $plainPassword = $form->get('plainPassword')->getData();
            $hashedPassword = $passwordEncoder->hashPassword($admin, $plainPassword);
            $admin->setPassword($hashedPassword);
            $admin->setRoles(['ROLE_ADMIN']); // Optional, default to admin

            $entityManager->persist($admin);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_login'); // Change to your login route

        }

        return $this->render('admin_registration/register.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
