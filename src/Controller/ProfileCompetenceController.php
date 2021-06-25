<?php

namespace App\Controller;

use App\Entity\Profile;
use App\Entity\ProfileCompetence;
use App\Form\AddProfileCompetenceType;
use App\Form\EditProfileCompetenceType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
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
     * Affiche les compétences d'un profil et permet d'ajouter un compétence au profil via un form
     * permet d'accéder aux autres fonctions du controller
     * @Route("")
     * @Route("/{profile}", name="show_profile_competences", requirements={"profile":"\d+"}, methods={"GET", "POST"})
     * @param Request $request
     * @param ?Profile $profile
     * @return Response
     */
    public function index(Request $request, ?Profile $profile): Response
    {
        if (
            !isset($profile) ||                                                                         // profile mal requêté
            (!$this->isGranted('ROLE_ADMIN') && !$this->isGranted('ROLE_COMMERCIAL') && $profile !== $this->getUser()->getProfile())    // profil interdit d'accès
        ) {
            $profile = $this->getUser()->getProfile();
            $this->addFlash('redirect', 'Vous avez été redirigé vers votre profil (erreur ou interdiction)');
        }

        $em = $this->getDoctrine()->getManager();
        $profileCompetences = $profile->getProfileCompetence();

        $newProfileCompetence = new ProfileCompetence();
        $newProfileCompetence->setProfile($profile);
        $profileCompetenceForm = $this->createForm(AddProfileCompetenceType::class, $newProfileCompetence);

        $profileCompetenceForm->handleRequest($request);

        if ($profileCompetenceForm->isSubmitted() && $profileCompetenceForm->isValid()) {

            $em->persist($newProfileCompetence);
            $em->flush();
            $this->addFlash('success', 'compétence ajoutée avec succès !');
        }

        return $this->render('profile_competence/index.html.twig', [
            'profile' => $profile,
            'profileCompetences' => $profileCompetences,
            'add_profile_competence_form' => $profileCompetenceForm->createView()
        ]);
    }

    /**
     * Permet de supprimer une compétence du profil (on travaille avec l'entité ProfileCompetence)
     * @Route("/remove/{profileCompetence}", name="remove_profile_competence", requirements={"profileCompetence":"\d+"})
     * @param Request $request
     * @param ProfileCompetence $profileCompetence
     * @return RedirectResponse
     */
    public function remove(ProfileCompetence $profileCompetence, Request $request) :RedirectResponse
    {
        if ($profileCompetence && ($this->isGranted('ROLE_ADMIN') || $this->getUser()->getProfile() === $profileCompetence->getProfile()) ) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($profileCompetence);
            $em->flush();
            $this->addFlash('success', 'La compétence "' . $profileCompetence->getCompetence()->getLibelle() . '" a été supprimée avec succès.');
        } else {
            throw $this->createNotFoundException('une erreur est survenue. La compétence n\'a pas pu être supprimée');
        }

        return $this->redirectToRoute('show_profile_competences', ['profile' => $profileCompetence->getProfile()->getId()]);
    }

    /**
     * Permet d'éditer une compétence du profil (propriétés liked et level)
     * @Route("/edit/{profileCompetence}", name="edit_profile_competence", requirements={"profileCompetence":"\d+"})
     * @param Request $request
     * @param ProfileCompetence $profileCompetence
     * @return RedirectResponse|Response
     */
    public function edit(Request $request, ProfileCompetence $profileCompetence)
    {
        if (is_null($profileCompetence)) throw $this->createNotFoundException('une erreur est survenue. La compétence est introuvable');

        $editForm = $this->createForm(EditProfileCompetenceType::class, $profileCompetence);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            // DO STUFF PERSIST
            $em = $this->getDoctrine()->getManager();
            $em->persist($profileCompetence);
            $em->flush();
            $this->addFlash('success', 'la compétence a été modifiée avec succès !');
            return $this->redirectToRoute('show_profile_competences', ['profile' => $profileCompetence->getProfile()->getId()]);
        }

        return $this->render('profile_competence/edit.html.twig', [
            'profile_competence' => $profileCompetence,
            'edit_profile_competence_form' => $editForm->createView()
        ]);
    }
}
