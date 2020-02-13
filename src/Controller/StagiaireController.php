<?php

namespace App\Controller;

use App\Entity\Stagiaire;
use App\Form\StagiaireFormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/stagiaire")
 */


class StagiaireController extends AbstractController
{
   /**
     * @Route("/", name="stagiaire_index")
     */
    public function index()
    {
        $stagiaires = $this->getDoctrine()
                        ->getRepository(Stagiaire::class)
                        ->getAll();

        return $this->render('stagiaire/index.html.twig', [
            'stagiaires' => $stagiaires,
        ]);
    }
    
    /**
    * @Route("/new", name="form_stagiaire")
    */
    public function newForm(Request $request){


        $newStagiaire = new Stagiaire();
        $form = $this->createForm(StagiaireFormType::class, $newStagiaire);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $newStagiaire = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($newStagiaire);
            $entityManager->flush();

            return $this->redirectToRoute('stagiaire_index');
        }


        return $this->render('stagiaire/formStagiaire.html.twig', [
        'stagiaire_form' => $form->createView()
        ]);
     }



    /**
    * @Route("/{id}", name="showOne_stagiaire")
    */
    public function showOne(Stagiaire $stagiaire){
        return $this->render('stagiaire/showOne.html.twig', ['stagiaire' => $stagiaire]
        );
    }
}
