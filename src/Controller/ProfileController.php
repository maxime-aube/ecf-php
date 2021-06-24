<?php

namespace App\Controller;

use App\Entity\Profile;
use App\Form\ProfileType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * Class ProfileController
 * @package App\Controller
 * @Route("/profile")
 * @IsGranted("ROLE_USER")
 */
class ProfileController extends AbstractController
{
    /**
     * Affiche un profil à partir de l'ID
     * @Route("")
     * @Route("/{profile}", name="show_profile", requirements={"profile"="\d+"})
     * @param ?Profile $profile
     * @return Response
     */
    public function index(?Profile $profile): Response
    {
        if (is_null($profile)) {
            $profile = $this->getUser()->getProfile();
        }
        // redirige vers le propre profil de l'utilisateur en cas de requête erronnée ou d'accès interdit
        if (!$this->isGranted('ROLE_ADMIN') && $profile !== $this->getUser()->getProfile()) {
            $this->addFlash('error', 'Redirection profil : le profil auquel vous avez tenté d\'accéder était introuvable ou ne vous est pas ouvert.' );
            $this->redirectToRoute('show_profile', ['profile' => $profile->getId()]);
        }

        return $this->render('profile/index.html.twig', [
            'profile' => $profile,
            'admin' => in_array('ROLE_ADMIN', $this->getUser()->getRoles())
        ]);
    }

    /**
     * Crée un nouveau profil (ne permet pas d'ajouter des compétences)
     * @Route("/new", name="new_profile")
     */
    public function new(Request $request): Response
    {
        $profile = new Profile();
        $form = $this->createForm(ProfileType::class, $profile);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($profile);
            $entityManager->flush();
        }

        return $this->render('profile/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/edit/{profile}", name="edit_profile", requirements={"profile":"\d+"})
     * @param Request $request
     * @param Profile $profile
     * @return Response
     */
    public function edit(Request $request, Profile $profile): Response
    {
        return $this->render('profile/edit.html.twig');
    }

    /**
     * @Route("/remove/{profile}", name="remove_profile", requirements={"profile":"\d+"})
     * @return Response
     */
    public function remove() :Response
    {
        return $this->render('profile/remove.html.twig');
    }







//
//    /**
//     *
//     * @Route("/edit/experiences/{profile}", name="edit_profile_experiences", requirements={"profile":"\d+"})
//     * @param Request $request
//     * @param Profile $profile
//     * @return Response
//     */
//    public function Experiences(Request $request, Profile $profile): Response
//    {
//
//    }
//
//    /**
//     *
//     * @Route("/edit/documents/{profile}", name="edit_profile_documents", requirements={"profile":"\d+"})
//     * @param Request $request
//     * @param Profile $profile
//     * @return Response
//     */
//    public function Documents(Request $request, Profile $profile): Response
//    {
//
//    }

}
