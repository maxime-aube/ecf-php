<?php

namespace App\Controller;

use App\Entity\Document;
use App\Entity\Profile;
use App\Form\DocumentsType;
use App\Service\FileUploader;
use DateTimeImmutable;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


/**
 * Gestion des fichiers de profil
 * Class DocumentController
 * @package App\Controller
 * @Route("/documents")
 * @IsGranted("ROLE_USER")
 */
class DocumentController extends AbstractController
{
    /**
     * Affiche la liste des documents uploadés par l'utilisateur sur son profil
     * Permet d'uploader de nouveaux documents de profil
     * @Route("")
     * @Route("/{profile}", name="show_documents", requirements={"profile":"\d+"}, methods={"GET"})
     * @param ?Profile $profile
     * @param Request $request
     * @param FileUploader $fileUploader
     * @return Response
     */
    public function index(?Profile $profile, Request $request, FileUploader $fileUploader): Response
    {
        if (
            !isset($profile) ||                                                                         // profile mal requêté
            (!$this->isGranted('ROLE_ADMIN') && !$this->isGranted('ROLE_COMMERCIAL') && $profile !== $this->getUser()->getProfile())    // profil interdit d'accès
        ) {
            $profile = $this->getUser()->getProfile();
            $this->addFlash('redirect', 'Vous avez été redirigé vers votre profil (erreur ou interdiction)');
        }

        $em = $this->getDoctrine()->getManager();

        $documents = $profile->getDocument(); // récupère une collection des documents du profil

        $addDocumentForm = $this->createForm(DocumentsType::class); // création du form pour l'ajout de documents
        $addDocumentForm->handleRequest($request);

        if ($addDocumentForm->isSubmitted() && $addDocumentForm->isValid()) {

            $documentFiles = $addDocumentForm['newDocuments']->getData();

            foreach ($documentFiles as $documentFile) {

                $document = new Document();
                $document->setProfile($profile);
                $document->setUploadedAt(new DateTimeImmutable());

                // sauvegarde du fichier uploadé via service FileUploader et création du nom de fichier correct
                $documentFileName = $fileUploader->upload($documentFile);
                $document->setFileName($documentFileName);
                // association du document au message et persist
                $em->persist($document);
            }

            $em->flush();

            $this->addFlash('success', "Upload réussi !");
            $this->redirectToRoute('show_documents', ['profile' => $profile->getId()]);
        }

        return $this->render('document/index.html.twig', [
            'documents' => $documents,
            'documents_form' => $addDocumentForm->createView()
        ]);
    }

    /**
     * Permet de supprimer un document du profil
     * @Route("/remove/{document}", name="remove_document", requirements={"document":"\d+"}, methods={"GET"})
     * @param Document $document
     * @return RedirectResponse
     */
     public function remove(Document $document)
     {
         // TODO -> fonctionnalité de suppression fichier

         $profile = $this->getUser()->getProfile();

         $this->addFlash('removed', 'Le fichier a bien été supprimé de votre profil');
         return $this->redirectToRoute('show_documents', ['profile' => $profile->getId()]);
     }
}
