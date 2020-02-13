<?php

namespace App\Form;

use App\Entity\Stagiaire;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class StagiaireFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('prenom')
            ->add('dateNaissance',DateType::class, [
                'label' => 'Date de naissance',
                'years' => range(date('Y'), date('Y')-102),
                'format' => 'dd-MM-yyyy',
            ])
            ->add('ville')
            ->add('mail')
            ->add('telephone',TextType::class,[
                'label' => 'Téléphone',
            ])

            ->add('sexe',ChoiceType::class, array('choices' => array(
                'Homme' => 'Homme',
                'Femme' => 'Femme',
                'Autre' => 'Autre',
               ),
            ))


                
            ->add('Valider', SubmitType::class)
      
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Stagiaire::class,
        ]);
    }
}
