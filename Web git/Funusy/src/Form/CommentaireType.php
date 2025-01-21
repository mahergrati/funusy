<?php

namespace App\Form;

use App\Entity\Commentaire;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Projet;

class CommentaireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('contenue', null, [
                'required' => false,
            ])
            ->add('dateCommentaire', DateType::class, [
                'label' => 'Commentaire Date',
                'widget' => 'single_text',
                'data' => new \DateTime(), // Initialise la date avec la date système
                'html5' => false, // Nécessaire pour utiliser le format de date souhaité
                'format' => 'yyyy-MM-dd', // Format de date ISO 8601
                'attr' => [
                    'class' => 'js-datepicker',
                    'required' => false, // Add the 'required' attribute and set it to false
                ],
            ])
            ->add('idProjet', EntityType::class, [
                'class' => Projet::class,
                'choice_label' => 'nomProjet',
                'placeholder' => 'Select Project',
                'required' =>false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Commentaire::class,
        ]);
    }
}