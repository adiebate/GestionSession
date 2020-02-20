<?php

namespace App\Form;

use App\Entity\Module;
use App\Entity\Session;
use App\Repository\ModuleRepository;
use Symfony\Component\Form\AbstractType;
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
                'label' => 'Date de début',
                'years' => range(date('Y'), date('Y')+2),
                'format' => 'ddMMyyyy',
                'invalid_message' => 'date invalide'
            ])
            ->add('DateFin', DateType::class, [                
                'label' => 'Date de fin',
                'years' => range(date('Y'), date('Y')+2),
                'format' => 'ddMMyyyy',
                'invalid_message' => 'date invalide',

                'constraints' => [
                    new Callback(function($object, ExecutionContextInterface $context){
                        $debut = $context->getRoot()->getData()['Datedebut'];
                        $fin = $object;

                            if(is_a($debut, \DateType::class) && is_a($fin, \DateType::class)) {
                                is($fin->format('U') - $debut->format('U') < 0) {
                                    $context
                                        ->buildViolation('La date de fin doit être après la date de début')
                                        ->addViolation()
                                };
                            }

                    }),
                ]

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
