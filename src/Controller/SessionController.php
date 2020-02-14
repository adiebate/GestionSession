<?php

namespace App\Controller;


use App\Entity\Session;
use App\Entity\Contenir;
use App\Entity\Stagiaire;
use App\Form\SessionFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/session")
 */
class SessionController extends AbstractController
{
    /**
     * @Route("/", name="session_index")
     */
    public function index()
    {

        $sessions = $this->getDoctrine()
                        ->getRepository(Session::class)
                        ->getAll();

        return $this->render('session/index.html.twig', [
            'sessions' => $sessions,
        ]);
    }

    /**
    * @Route("/new", name="form_session")
    */
    public function newForm(Request $request){


        $newSession = new Session();
        $form = $this->createForm(SessionFormType::class, $newSession);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            
            $newSession = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($newSession);
            $entityManager->flush();

            return $this->redirectToRoute('session_index');
        }

        return $this->render('session/formSession.html.twig', [
        'session_form' => $form->createView()
        ]);
     }


    /**
     * @Route("/edit/{id}", name="edit_session")
     */
    public function editSession(Session $session, Request $request, EntityManagerInterface $entityManager){

        $form = $this->createForm(SessionFormType::class, $session);


        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $entityManager->flush();

            return $this->redirectToRoute("session_index");
        }

        return $this->render('session/formSession.html.twig', [
            "session_form" => $form->createView()
        ]);
    }

    /**
    * @Route("/delete/{id}", name="remove_one_session")
    */
    public function removeOneSession(Session $session, EntityManagerInterface $entityManager){

        $entityManager->remove($session);
        $entityManager->flush();


    return $this->redirectToRoute("session_index");
 }


    /**
    * @Route("/", name="remove_one_stagiaire_from_session")
    */
     public function removeOneStagiaireFromSession(Stagiaire $stagiaire, EntityManagerInterface $entityManager){

            $entityManager->removeStagiaire($stagiaire);
            $entityManager->flush();


        return $this->redirectToRoute("show_one_session");
     }


    /**
     * @Route("/{id}", name="show_one_session", methods="GET")
     */
     public function showOne(Session $session, Contenir $contenir){

         return $this->render('session/showOne.html.twig', ['session' => $session]);
     }



    

}
