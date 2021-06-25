<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * Class DashboardController
 * @package App\Controller
 */
class DashboardController extends AbstractController
{
    /**
     * @Route("/", name="default")
     * @Route("/dashboard", name="dashboard")
     * @IsGranted("ROLE_USER")
     * @return RedirectResponse|Response
     */
    public function index()
    {
        // rejet si non connecté
        // accès réservé aux commerciaux/admin
        // redirection en cas de rejet: not auth->login, auth not allowed -> own profile (collaborateur)

        if (!$this->isGranted('ROLE_ADMIN') && !$this->IsGranted('ROLE_COMMERCIAL')) {
            return $this->redirectToRoute('show_profile', ['profile' => $this->getUser()->getProfile()->getId()]);
        }

        return $this->render('dashboard/index.html.twig', [
            'controller_name' => 'DashboardController',
            'user' => $this->getUser()
        ]);
    }
}
