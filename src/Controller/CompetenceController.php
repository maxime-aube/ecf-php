<?php

namespace App\Controller;

use App\Entity\Profile;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Gestion des compétences associées à un profil
 * Class CompetenceController
 * @Route("/competence")
 * @package App\Controller
 */
class CompetenceController extends AbstractController
{
    /** Affiche les compétences d'un profil
     * @Route("/{profile}", name="show_competences", requirements={"profile":"\d+"}, methods={"GET"})
     */
    public function index(Profile $profile): Response
    {
        $em = $this->getDoctrine()->getManager();

        if (!isset($profile)) {
            /** @var Profile $profile */
            $profile = $this->getUser()->getProfile();
        }

        return $this->render('competence/index.html.twig', [
            'comp' => 'CompetenceController',
        ]);
    }

    /**
     * Ajoute une compétence au profil
     * @Route("/add/{profile}", name="add_competences", requirements={"profile":"\d+"}, methods={"POST"})
     */
    public function add() :Response
    {

    }

    /**
     * Modifie une compétence du profil
     * @Route("/edit/{profile}", name="edit_competences", requirements={"profile":"\d+"}, methods={"PUT"})
     */
    public function edit() :Response
    {

    }

    /**
     * Supprime une compétence du profil
     * @Route("/remove/{profile}", name="remove_competences", requirements={"profile":"\d+"}, methods={"DELETE"})
     */
    public function remove() :Response
    {

    }

}
