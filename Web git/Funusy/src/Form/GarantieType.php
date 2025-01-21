<?php

namespace App\Form;

use App\Entity\Garantie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class GarantieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('idCredit', null, [
                'required' => false,
            ])
            ->add('natureGarantie', ChoiceType::class, [
                'choices' => [
                    'Maison' => 'Maison',
                    'Voiture' => 'Voiture',
                    'Terrain' => 'Terrain',
                    'Local Commercial' => 'Local Commercial',
                ],
                'label' => 'Nature de la garantie',
                'placeholder' => 'Choose an option',
                'required' => false,
            ])
            ->add('valeurGarantie', null, [
                'required' => false,
            ])
            ->add('preuve', FileType::class, [
                'label' => 'Preuve (PDF file)',
                'required' => false,
                'mapped' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'application/pdf',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid PDF document',
                    ]),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Garantie::class,
        ]);
    }

}
