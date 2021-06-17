<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    /**
     * @Route("/", name="default")
     * @Route("/dashboard", name="dashboard")
     */
    public function index(): Response
    {
        // rejet si non connecté
        // accès réservé aux commerciaux/admin
        // redirection en cas de rejet: not auth->login, auth not allowed -> own profile (collaborateur)

        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        return $this->render('dashboard/index.html.twig', [
            'controller_name' => 'DashboardController',
            'user' => $this->getUser()
        ]);
    }
}
