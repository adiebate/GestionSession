<?php

namespace App\Form;

use App\Entity\Module;
use App\Entity\Session;
use App\Entity\Contenir;
use App\Repository\ModuleRepository;
use App\Repository\ContenirRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class AjoutModuleFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('module', EntityType::class, [
                'class' => Module::class,
                'query_builder' => function (ModuleRepository $er) {
                    return $er->createQueryBuilder('m')
                        ->orderBy('m.intitule');
                },
                'choice_label' => 'intitule',
            ])
            ->add('NbJours')
            ->add("Valider", SubmitType::class,[
                'attr' => ['class' => 'submit'],
            ])
        ;
    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Contenir::class,
        ]);
    }
}
