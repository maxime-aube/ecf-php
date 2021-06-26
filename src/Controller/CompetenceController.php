<?php

namespace App\Controller;

use App\Entity\Competence;
use App\Entity\Profile;
use App\Entity\User;
use App\Form\CompetenceType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


/**
 * Gestion des compétences de la nomenclature de compétences
 * Class CompetenceController
 * @package App\Controller
 * @IsGranted("ROLE_ADMIN")
 */
class CompetenceController extends AbstractController
{
    /**
     * @Route("/competences", name="competences", methods={"GET", "POST"})
     */
    public function index(Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();
        $competences = $em->getRepository(Competence::class)->findAll();

        $newCompetence = new Competence();
        $addCompetenceForm = $this->createForm(CompetenceType::class, $newCompetence);
        $addCompetenceForm->handleRequest($request);

        if ($addCompetenceForm->isSubmitted() && $addCompetenceForm->isValid()) {
            $em->persist($newCompetence);
            $em->flush();
        }

        return $this->render('competence/index.html.twig', [
            'competences' => $competences,
            'form' => $addCompetenceForm->createView()
        ]);
    }
}
