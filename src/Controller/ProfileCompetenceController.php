<?php

namespace App\Controller;

use App\Entity\Profile;
use App\Entity\ProfileCompetence;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * Gestion des compétences associées à un profil
 * Class ProfileCompetenceController
 * @Route("/profile_competences")
 * @package App\Controller
 * @IsGranted("ROLE_USER")
 */
class ProfileCompetenceController extends AbstractController
{

    /**
     * Affiche les compétences d'un profil
     * permet d'accéder aux autres fonctions du controller
     * @Route("")
     * @Route("/{profile}", name="show_profile_competences", requirements={"profile":"\d+"}, methods={"GET"})
     * @param ?Profile $profile
     * @return Response
     */
    public function index(?Profile $profile): Response
    {

        if (
            !isset($profile) ||                                                                         // profile mal requêté
            (!$this->isGranted('ROLE_ADMIN') && $profile !== $this->getUser()->getProfile())    // profil interdit d'accès
        ) {
            $profile = $this->getUser()->getProfile();
        }

        $profileCompetences = $profile->getProfileCompetence();

        // TODO -> formulaire de ProfileCompetence
//        $this->createForm('')

        return $this->render('profile_competence/index.html.twig', [
            'profile' => $profile,
            'profileCompetences' => $profileCompetences
        ]);
    }

    /**
     * permet d'ajouter une compétence via un formulaire (liste les compétences de la nomenclature, exclus celles déjà ajoutées)
     * @Route("/add/{profile}", name="add_profile_competence", requirements={"profile":"\d+"}, methods={"POST"})
     * @param Request $request
     * @param Profile $profile
     * @return Response
     */
    public function add(Request $request, Profile $profile) :Response
    {
    }

    /**
     * Permet de supprimer une compétence du profil (on travaille sur ProfileCompetence)
     * @Route("/remove/{profileCompetence}", name="remove_profile_competence", requirements={"profileCompetence":"\d+"}, methods={"DELETE"})
     */
    public function remove(Request $request, ProfileCompetence $profileCompetence) :Response
    {

    }

    /**
     * Permet d'éditer une compétence du profil (propriétés liked et level)
     * @Route("edit/{profileCompetence}", name="edit_profile_competence", requirements={"profileCompetence":"\d+"}, methods={"DELETE"})
     * @return Response
     */
    public function edit(ProfileCompetence $profileCompetence): Response
    {
        // TODO -> décider si méthodes séparées pour liked et level
    }
}
