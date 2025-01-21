<?php

namespace App\Form;

use App\Entity\CarteBancaire;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;


class CarteBancaireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dateExp')
            ->add('code')
            ->add('cvv2')
            ->add('rib')
            ->add('num_carte')
            ->add('image', FileType::class, [
                'label' => 'Upload ID Card Image',
                'mapped' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CarteBancaire::class,
        ]);
    }
}
