<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AuthenticatorController extends AbstractController
{
    /**
     * @Route("")
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // dashboard pour les admins et commerciaux (utilisateurs de la structure)
         if ($this->isGranted('ROLE_ADMIN') || $this->isGranted('ROLE_COMMERCIAL')) return $this->redirectToRoute('admin');
         // affichage profil pour les collaborateurs
         if ($this->isGranted('ROLE_USER')) {
             return $this->redirectToRoute('show_profile', ['profile' => $this->getUser()->getProfile()->getId()]);
         }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.'); // Ok...
    }
}
