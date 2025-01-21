<?php

namespace App\Form;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use App\Repository\CompteRepository;
use App\Entity\Compte;
use App\Entity\Transaction;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
class TransactionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void

    {

        $builder

            ->add('montantTransaction', MoneyType::class, [

                 

                'divisor' => 1, // Convert centime to euro

                'label' => 'Montant Transaction (in TND)',

            ])

            ->add('dateTransaction', DateTimeType::class, [

                'widget' => 'single_text',

                'label' => 'Date Transaction',

                'data' => new \DateTime(), // Set the current date and time

                'disabled' => true, // Disable the field to prevent user input

            ])

            ->add('destination', EntityType::class, [

                'class' => Compte::class,

                'query_builder' => function (CompteRepository $repository) {

                    return $repository->createQueryBuilder('c')

                        ->where('c.rib = :rib')

                        ->setParameter('rib', 'RIBTEST')

                        ->orderBy('c.id_user', 'ASC');

                },

                'choice_label' => 'rib',

                'label' => 'Destination',

            ])

            ->add('typeTransaction', ChoiceType::class, [

                'choices' => [

                    'TRANSFERT' => 'TRANSFERT',

                ],

                'label' => 'type_transaction',

            ])
            ->add('rib', TextType::class, [

                'data' => 'RIBTEST',

                'mapped' => false,

                'label' => 'RIB',

            ]);


        // Set the default value for the rib field

        $builder->get('rib')->setData('RIBTEST');
        $builder->get('typeTransaction')->setData('TRANSFERT');
    }


    public function configureOptions(OptionsResolver $resolver): void

    {

        $resolver->setDefaults([

            'data_class' => Transaction::class,

            'compte_repository' => null,

        ]);

    }

}