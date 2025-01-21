<?php
namespace App\Form;

use App\Entity\Projet;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class ProjetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomProjet', TextType::class, [
                'label' => 'Nom du projet',
                'attr' => ['placeholder' => 'Project name'],
                'required' => false,
            ])
            ->add('montantReq', TextType::class, [
                'label' => 'Montant requis',
                'attr' => ['placeholder' => 'Required amount'],
                'required' => false,
            ])
            ->add('latitude', HiddenType::class)
            ->add('longitude', HiddenType::class)
            
            ->add('typeProjet', ChoiceType::class, [
                'choices' => [
                    'AGRICULTURE' => 'AGRICULTURE',
                    'BOURSE' => 'BOURSE',
                    'IMMOBILIER' => 'IMMOBILIER',
                    'TECHNOLOGIQUE' => 'TECHNOLOGIQUE',
                ],
                'label' => 'Type de projet',
                'required' => false,
            ])
            ->add('description', TextType::class, [
                'label' => 'Description',
                'attr' => ['placeholder' => 'Description'],
                'required' => false,
            ])
            ->add('user', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'nomUser', // Update to match the actual property of User entity
                'placeholder' => 'Select a user', // optional
                'required' => false,
            ])
            ->add('fullLocation', TextType::class, [
                'label' => 'Full Location Name',
                'mapped' => false, // This field is not mapped to any entity property
                'attr' => ['readonly' => true], // Make the field read-only
                'required' => false,
            ]);
            
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Projet::class,
        ]);
    }
}
