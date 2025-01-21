<?php

namespace App\Form;

use App\Entity\Credit;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CreditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('montantCredit', null, [
                'required' => false,
            ])
            ->add('dureeCredit', null, [
                'required' => false,
            ])
            ->add('dateCredit', DateType::class, [
                'label' => 'Credit Date',
                'widget' => 'single_text',
                'data' => new \DateTime(), // Initialise la date avec la date système
                'html5' => false, // Nécessaire pour utiliser le format de date souhaité
                'format' => 'yyyy-MM-dd', // Format de date ISO 8601
                'attr' => [
                    'class' => 'js-datepicker',
                    'required' => false, // Add the 'required' attribute and set it to false
                ],
            ])
            ->add('tauxCredit', null, [
                'required' => false,
            ])
            ->add('user', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'nomUser',
                'placeholder' => 'Select user',
                'required' => false,
            ])
            ->add('status', ChoiceType::class, [
                'choices' => [
                    'Non traité' => 'Non traité',
                    'Accepted' => 'Accepted',
                    'Rejected' => 'Rejected',
                ],
                'label' => 'Status',
                'placeholder' => 'Select status',
                'required' => false, // Champs requis
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Credit::class,
        ]);
    }
}
