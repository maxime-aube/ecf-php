<?php

namespace App\Controller;

use App\Entity\Experience;
use App\Entity\Profile;
use App\Form\AddExperienceType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * Class ExperienceController
 * @package App\Controller
 * @Route("/experiences")
 * @IsGranted("ROLE_USER")
 */
class ExperienceController extends AbstractController
{
    /**
     * Affiche les expériences/missions d'un profil
     * @Route("")
     * @Route("/{profile}", name="show_experiences", requirements={"profile":"\d+"}, methods={"GET", "POST"})
     * @param Request $request
     * @param Profile|null $profile
     * @return Response
     */
    public function index(Request $request, ?Profile $profile)
    {
        if (
            !isset($profile) ||                                                                         // profile mal requêté
            (!$this->isGranted('ROLE_ADMIN') && !$this->isGranted('ROLE_COMMERCIAL') && $profile !== $this->getUser()->getProfile())    // profil interdit d'accès
        ) {
            $profile = $this->getUser()->getProfile();
            $this->addFlash('redirect', 'Vous avez été redirigé vers votre profil (erreur ou interdiction)');
        }

        $profile->getExperiences();

        return $this->render('experience/index.html.twig', [
            'experiences' => $profile->getExperiences(),
            'profile' => $profile
        ]);
    }

    /**
     * @param Request $request
     * @param Profile $profile
     * @Route("/add/{profile}", name="add_experience", requirements={"profile":"\d+"}, methods={"GET", "POST"})
     * @return RedirectResponse|Response
     */
    public function add(Request $request, Profile $profile) {

        $em = $this->getDoctrine()->getManager();
        $experience = new Experience();
        $experience->setProfile($profile);
        $addExperienceForm = $this->createForm(AddExperienceType::class, $experience);

        $addExperienceForm->handleRequest($request);

        if($addExperienceForm->isSubmitted() && $addExperienceForm->isValid()) {
            $em->persist($experience);
            $em->flush();
            $this->addFlash('success', 'Experience correctement créée');
            return $this->redirectToRoute('show_experiences', ['profile' => $profile->getId()]);
        }

        return $this->render('experience/add.html.twig', [
           'form' => $addExperienceForm->createView()
        ]);
    }

    /**
     * @Route("/edit/{experience}", name="edit_experience", requirements={"experience":"\d+"}, methods={"GET", "POST"})
     * @param Request $request
     * @param Experience $experience
     * @return RedirectResponse|Response
     */
    public function edit(Request $request, Experience $experience) {

        if (is_null($experience)) {
            $this->addFlash('error', 'Cette expérience n\'a pas été trouvée');
            return $this->redirectToRoute('show_experiences', ['profile' => $this->getUser()->getProfile()->getId()]);
        }

        $em = $this->getDoctrine()->getManager();
        $editExperienceForm = $this->createForm(AddExperienceType::class, $experience);

        $editExperienceForm->handleRequest($request);

        if($editExperienceForm->isSubmitted() && $editExperienceForm->isValid()) {
            $em->persist($experience);
            $em->flush();
            $this->addFlash('success', 'Experience modifiée !');
            return $this->redirectToRoute('show_experiences', ['profile' => $this->getUser()->getProfile()->getId()]);
        }

        return $this->render('experience/add.html.twig', [
            'form' => $editExperienceForm->createView()
        ]);
    }
}
