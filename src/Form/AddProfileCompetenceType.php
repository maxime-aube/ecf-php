<?php

namespace App\Form;

use App\Entity\ProfileCompetence;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddProfileCompetenceType extends AbstractType
{
    // TODO -> faire une liste custom pour ne pas afficher les compétences que l'utilisateur a déjà dans le select (competence)
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('competence')
            ->add('level')
            ->add('liked')
            ->add('submit', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ProfileCompetence::class,
        ]);
    }
}
