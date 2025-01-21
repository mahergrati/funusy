<?php

namespace App\Form;

use App\Entity\Signale;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SignaleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dateSignal', DateType::class, [
                'label' => 'Signal Date',
                'widget' => 'single_text',
                'data' => new \DateTime(), // Initialise la date avec la date système
                'html5' => false, // Nécessaire pour utiliser le format de date souhaité
                'format' => 'yyyy-MM-dd', // Format de date ISO 8601
                'attr' => [
                    'class' => 'js-datepicker',
                    'required' => false, // Add the 'required' attribute and set it to false
                ],
            ])
            ->add('description', null, [
                'required' => false,
            ])
            ->add('idCommentaire')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Signale::class,
        ]);
    }
}
