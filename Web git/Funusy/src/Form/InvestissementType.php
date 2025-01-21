<?php
namespace App\Form;

use App\Entity\Investissement;
use App\Entity\User;
use App\Entity\Projet;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType; // Use IntegerType for periode
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual; // Corrected constraint class
use Karser\Recaptcha3Bundle\Form\Recaptcha3Type;
use Karser\Recaptcha3Bundle\Validator\Constraints\Recaptcha3;

class InvestissementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('montant')
            ->add('dateInv', DateType::class, [
                'constraints' => [
                    new NotBlank(),
                    new GreaterThanOrEqual(['value' => new \DateTime('+1 day')]),
                ],
                'label' => 'Investment Date',
                'widget' => 'single_text',
            ])
            ->add('periode', IntegerType::class, [ // Use IntegerType for periode
                'label' => 'Period (in months)',
                'required' => false, // Set periode field as optional
                'attr' => ['min' => 3, 'max' => 60], // Define minimum and maximum values
            ])
            ->add('user', EntityType::class, [
                'class' => User::class,
                'required' => false,
                'choice_label' => 'nomUser',
                'placeholder' => 'Select a user',
                'label' => 'User',
            ])
            ->add('projet', EntityType::class, [
                'class' => Projet::class,
                'choice_label' => 'nomProjet',
                'required' => false,
                'placeholder' => 'Select a project',
                'label' => 'Project',
            ])
            ->add('captcha', Recaptcha3Type::class, [
                'constraints' => new Recaptcha3(),
                'action_name' => 'homepage',
            
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Investissement::class,
        ]);
    }
}
