<?php

namespace App\Form;

use App\Entity\Module;
use App\Entity\Session;
use App\Repository\ModuleRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class SessionFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('intitule', TextType::class )
            ->add('DateDebut', DateType::class, [
                'label' => 'Date de début',
                'years' => range(date('Y'), date('Y')+2),
                'format' => 'ddMMyyyy',
                'invalid_message' => 'date invalide'
            ])
            ->add('DateFin', DateType::class, [                
                'label' => 'Date de fin',
                'years' => range(date('Y'), date('Y')+2),
                'format' => 'ddMMyyyy',
                'invalid_message' => 'date invalide'
            ])
            ->add('NbPlaces', IntegerType::class,  [
                'label' => 'Nombre de places disponible',
            ])
            // ->add('')
            ->add('Valider', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Session::class,
        ]);
    }
}
