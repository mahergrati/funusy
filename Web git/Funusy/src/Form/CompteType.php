<?php

namespace App\Form;

use App\Entity\Compte;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\User;
use Symfony\Component\Validator\Constraints\NotBlank;


class CompteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
           
        ->add('typeCompte', ChoiceType::class, [
            'choices' => [
                '   Bloqué' => 'bloque', '   Courant' => 'courant', '   Epargne' => 'epargne',
            ],
            'label' => 'Account Type',
            'expanded' => true, // Render as radio buttons
            'multiple' => false, // Allow only one selection
            'constraints' => [
                new NotBlank(['message' => 'Please select an account type.']),
            ],
        ])
            ->add('dateOuverture', DateType::class, [
                'label' => 'Opening Date',
                'widget' => 'single_text',
                'html5' => false,
                'attr' => ['class' => 'form-control'],
                'data' => new \DateTime(), // Set the default value to current date
            ])
           
            
            ->add('rib', TextType::class, [
                'attr' => ['readonly' => true],
            ])
            
            ->add('solde', TextType::class, [
                'label' => 'Balance',
                'constraints' => [
                    new Assert\GreaterThan(0),
                ],
            ])

            ->add('user', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'id_user', 
                'placeholder' => 'Select a user', 
                'required' => true, 
            ]);
        
    }

   
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Compte::class,
        ]);
    }

   
}
