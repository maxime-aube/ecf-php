<?php

namespace App\Controller\Admin;

use App\Entity\Profile;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("")
     * @Route("dashboard")
     * @Route("/admin", name="admin")
     * @IsGranted("ROLE_USER")
     */
    public function index(): Response
    {
        // redirige vers le propre profil de l'utilisateur en cas de requête erronnée ou d'accès interdit
        if (!$this->isGranted('ROLE_ADMIN') && !$this->isGranted('ROLE_COMMERCIAL')) {
            $this->addFlash('redirect', 'Vous avez été redirigé vers votre profil (erreur ou interdiction)');
            return $this->redirectToRoute('show_profile', ['profile' => $this->getUser()->getProfile()->getId()]);
        }

        return parent::index();
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Skillhub');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Profiles', 'fas fa-list', Profile::class);
    }
}
