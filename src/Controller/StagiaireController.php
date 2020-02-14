<?php

namespace App\Controller;

use App\Entity\Session;
use App\Entity\Stagiaire;
use App\Form\StagiaireFormType;
use Doctrine\ORM\EntityManagerInterface;
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
     * @Route("/edit/{id}", name="edit_stagiaire")
     */
    public function editStagiaire(Stagiaire $stagiaire, Request $request, EntityManagerInterface $entityManager){

        $form = $this->createForm(StagiaireFormType::class, $stagiaire);


        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $entityManager->flush();

            return $this->redirectToRoute("stagiaire_index");
        }

        return $this->render('stagiaire/formStagiaire.html.twig', [
            "stagiaire_form" => $form->createView()
        ]);
    }
     

    /**
    * @Route("/{id}/removesession/{id_session}", name="remove_one_session_from_stagiaire")
    */
    public function removeOneSessionFromStagiaire(Stagiaire $stagiaire, Request $request){

        $id = $request->attributes->get('id_session');
        $entityManager = $this->getDoctrine()->getManager();
        $session = $this->getDoctrine()->getRepository(Session::class)->find($id);
        $stagiaire->removeInscription($session);
        $entityManager->flush();


    return $this->redirectToRoute("showOne_stagiaire", array('id' => $stagiaire->getId()));
 }

    /**
    * @Route("/delete/{id}", name="remove_one_stagiaire")
    */
    public function removeOnestagiaire(Stagiaire $stagiaire, EntityManagerInterface $entityManager){

        $entityManager->remove($stagiaire);
        $entityManager->flush();


    return $this->redirectToRoute("stagiaire_index");
 }

    /**
    * @Route("/{id}", name="showOne_stagiaire")
    */
    public function showOne(Stagiaire $stagiaire){
        return $this->render('stagiaire/showOne.html.twig', ['stagiaire' => $stagiaire]
        );
    }
}
