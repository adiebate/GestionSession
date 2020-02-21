<?php

namespace App\Form;

use App\Entity\Module;
use App\Entity\Session;
use App\Repository\ModuleRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Validator\Constraints;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class SessionFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('intitule', TextType::class )
            ->add('DateDebut', DateType::class, [
                'widget' => "single_text",
                'data' => new \DateTime('now'),
                'label' => 'Date de début',
                'years' => range(date('Y'), date('Y')+2),
                
                'invalid_message' => 'date invalide'
            ])
            ->add('DateFin', DateType::class, [
                'widget' => "single_text",
                'data' => new \DateTime('now'),                
                'label' => 'Date de fin',
                'years' => range(date('Y'), date('Y')+2),
                'invalid_message' => 'date invalide',
            ])
            ->add('NbPlaces', IntegerType::class,  [
                'label' => 'Nombre de places disponible',
            ])
            // ->add('')
            ->add('Valider', SubmitType::class, [
                'attr' => ['class' => 'submit']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Session::class,
        ]);
    }
}
