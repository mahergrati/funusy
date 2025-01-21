<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Signup3Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nomUser', TextType::class, [
                'label' => ' ',
                'required' => true,
            ])
            ->add('prenomUser', TextType::class, [
                'label' => ' ',
                'required' => true,
            ])
            ->add('dateNaissance', DateType::class, [
                'label' => ' ',
                'widget' => 'single_text',
                'required' => true,
            ])
            ->add('cin', IntegerType::class, [
                'label' => ' ',
                'required' => true,
            ])
            ->add('tel', IntegerType::class, [
                'label' => ' ',
                'required' => true,
            ])
            ->add('salaire', IntegerType::class, [
                'label' => ' ',
                'required' => true,
            ])
            ->add('adresseUser', TextType::class, [
                'label' => ' ',
                'required' => true,
            ])
           ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
