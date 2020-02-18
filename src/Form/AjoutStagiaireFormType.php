<?php

namespace App\Form;

use App\Entity\Stagiaire;
use App\Repository\StagiaireRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class AjoutStagiaireFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            
        ->add('stagiaire', EntityType::class, [
            'class' => Stagiaire::class,
            'mapped' => false,

            'query_builder' => function (StagiaireRepository $er) {
                // return $er->getListDontInscritStagiaires();

                return $er->createQueryBuilder('st')
                    
                    // ->where('st.id != 1' )
                    ->orderBy('st.nom');
            },
            'choice_label' => function(Stagiaire $stagiaire){
                return $stagiaire->getNom() .' '. $stagiaire->getPrenom(); }
        ])
        ->add("Valider", SubmitType::class,[
            'attr' => ['class' => 'submit'],
        ]);
    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => null,
        ]);
    }
}
