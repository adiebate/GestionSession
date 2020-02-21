<?php

namespace App\Form;

use App\Entity\Session;
use App\Entity\Stagiaire;
use App\Repository\SessionRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class AjoutSessionFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            
            ->add('session', EntityType::class, [
                'class' => Session::class,
                'mapped' => false,
                'query_builder' => function (SessionRepository $er) {
                    $qb = $er->createQueryBuilder('se');
                    return $qb->andWhere($qb->expr()->gt('se.NbPlaces', ':nbstagiaires'))
                              ->setParameter('nbstagiaires', $qb->expr()->count('se.stagiaires'))
                              ->orderBy('se.intitule');
                },
                'choice_label' => 'intitule',
            ])
            ->add("Valider", SubmitType::class,[
                'attr' => ['class' => 'submit'],
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => null,
        ]);
    }
}
