<?php

namespace App\Form;

use App\Entity\Document;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\All;
use Symfony\Component\Validator\Constraints\File;

class DocumentsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('newDocuments', FileType::class, [
                'label' => 'sélectionner des fichiers',
                'multiple' => true,
                'data_class' => null,
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new All([
                        new File([
                            'maxSize' => '5Mi', // par exemple
                            'mimeTypes' => self::DOCUMENT_MIME_TYPES,
                            'mimeTypesMessage' => 'ce format de fichier n\'est pas accepté'
                        ])
                    ])
                ]
            ])
            ->add('submit', SubmitType::class)
        ;

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Document::class,
        ]);
    }

    public const DOCUMENT_MIME_TYPES = [
        "image/jpeg", "image/gif", "image/png", "image/bmp", //images
        "text/plain", "application/msword", "application/vnd.ms-excel", "application/vnd.openxmlformats-officedocument.wordprocessingml.document", //text
        "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet", "application/vnd.openxmlformats-officedocument.wordprocessingml.document", //open documents
        "application/vnd.oasis.opendocument.spreadsheet", "application/vnd.oasis.opendocument.text",//open documents
        "application/pdf", "application/x-pdf",//pdf
        "application/x-rar-compressed", "application/x-tar", "application/zip", "application/x-7z-compressed" //archives
    ];
}
