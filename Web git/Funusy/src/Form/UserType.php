<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomUser')
            ->add('prenomUser')
            ->add('emailUser')
            ->add('mdp')
            ->add('salaire')
            ->add('dateNaissance', DateType::class, [
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
            ])
            ->add('cin')
            ->add('tel')
            ->add('adresseUser', ChoiceType::class, [
                'label' => 'Adresse',
                'choices' => [
                    'ARIANA' => 'ARIANA',
                    'BEJA' => 'BEJA',
                    'BEN_AROUS' => 'BEN_AROUS',
                    'BIZERTE' => 'BIZERTE',
                    'GABES' => 'GABES',
                    'GAFSA' => 'GAFSA',
                    'JENDOUBA' => 'JENDOUBA',
                    'KAIROUAN' => 'KAIROUAN',
                    'KASSERINE' => 'KASSERINE',
                    'KEBILI' => 'KEBILI',
                    'KEF' => 'KEF',
                    'MAHDIA' => 'MAHDIA',
                    'MANOUBA' => 'MANOUBA',
                    'MEDENINE' => 'MEDENINE',
                    'MONASTIR' => 'MONASTIR',
                    'NABEUL' => 'NABEUL',
                    'SFAX' => 'SFAX',
                    'SIDI_BOUZID' => 'SIDI_BOUZID',
                    'SILIANA' => 'SILIANA',
                    'SOUSSE' => 'SOUSSE',
                    'TATAOUINE' => 'TATAOUINE',
                    'TOZEUR' => 'TOZEUR',
                    'TUNIS_CAPITALE' => 'TUNIS_CAPITALE',
                    'ZAGHOUAN' => 'ZAGHOUAN',
                ],
                'placeholder' => 'Select an address',
                'required' => true,
            ])
            ->add('roleUser', ChoiceType::class, [
                'label' => 'Role',
                'choices' => [
                    'ADMIN' => 'ADMIN',
                    'CLIENT' => 'CLIENT',
                ],
                'placeholder' => 'Select a role',
                'required' => true,
            ])
                        ->add('numericCode')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
