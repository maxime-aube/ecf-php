<?php

namespace App\Controller;

use App\Entity\Competence;
use App\Entity\Profile;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


/**
 * Gestion des compétences de la nomenclature de compétences
 * Class CompetenceController
 * @Route("/competences")
 * @package App\Controller
 * @IsGranted("ROLE_ADMIN")
 */
class CompetenceController extends AbstractController
{
    /**
     * @Route("")
     * @Route("/competences", name="show_competences")
     */
    public function index(): Response
    {
        $em = $this->getDoctrine()->getManager();
        $competences = $em->getRepository(Competence::class)->findAll();

        return $this->render('competence/index.html.twig', [
            'competences' => $competences
        ]);
    }



}
