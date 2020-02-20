<?php

namespace App\Controller;


use App\Entity\Module;
use App\Entity\Session;
use App\Entity\Contenir;
use App\Entity\Stagiaire;
use App\Form\SessionFormType;
use App\Form\AjoutModuleFormType;
use App\Form\AjoutStagiaireFormType;
use App\Repository\StagiaireRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
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

        return $this->render('session/sessionForm.html.twig', [
        'session_form' => $form->createView()
        ]);
     }


    /**
    * @Route("/newModule/{id}", name="ajout_module")
    */
    public function AjoutModuleForm(Session $session, Request $request){


        $newAjoutModule= new Contenir();
        $newAjoutModule->setSession($session);

        $form = $this->createForm(AjoutModuleFormType::class, $newAjoutModule);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            
            $newAjoutModule = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($newAjoutModule);
            $entityManager->flush();

            return $this->redirectToRoute("show_one_session", array('id' => $session->getId()));
        }

        return $this->render('session/ajoutModuleForm.html.twig', [
            'ajoutmoduleform' => $form->createView(),
            'session' => $session
        ]);
     }


     /**
    * @Route("/newStagiaire/{id}", name="ajout_stagiaire")
    */
    public function AjoutStagiaireForm(Session $session, Request $request, EntityManagerInterface $em){

        $stagiaires = $em->getRepository(Stagiaire::class)->findAll();

        foreach($stagiaires as $key => $stagiaire){
            if($session->getStagiaires()->contains($stagiaire)){
                unset($stagiaires[$key]);
            }
        }

        
        /*if ($form->isSubmitted() && $form->isValid()) {
            
            $newAjoutStagiaire = $request->get('stagiaire')->getData();

            $session->addStagiaire($newAjoutStagiaire);

            // $entityManager = $this->getDoctrine()->getManager();
            // $entityManager->persist($stagiaire);
            $em->flush();

            return $this->redirectToRoute("show_one_session", array('id' => $session->getId()));
        }*/

        return $this->render('session/ajoutStagiaireForm.html.twig', [
            'stagiairesDispo' => $stagiaires,
            'session' => $session
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

        return $this->render('session/sessionForm.html.twig', [
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
    * @Route("/{id}/removemodule/{id_contenir}", name="remove_one_module_from_session")
    */
    public function removeOneModuleFromSession(Session $session, Request $request){

        $id = $request->attributes->get('id_contenir');
        $entityManager = $this->getDoctrine()->getManager();
        $contenir = $this->getDoctrine()->getRepository(Contenir::class)->findOneBy([
            'session'=> $session->getId(),
            'module'=> $id
        ]);
        $entityManager->remove($contenir);
        $entityManager->flush();


    return $this->redirectToRoute("show_one_session", array('id' => $session->getId()));
 }

    /**
    * @Route("/{id}/removestagiaire/{id_stagiaire}", name="remove_one_stagiaire_from_session")
    */
     public function removeOneStagiaireFromSession(Session $session, Request $request){

            $id = $request->attributes->get('id_stagiaire');
            $entityManager = $this->getDoctrine()->getManager();
            $stagiaire = $this->getDoctrine()->getRepository(Stagiaire::class)->find($id);
            $session->removeStagiaire($stagiaire);
            $entityManager->flush();


        return $this->redirectToRoute("show_one_session", array('id' => $session->getId()));
     }


    /**
     * @Route("/{id}", name="show_one_session", methods="GET")
     */
     public function showOne(Session $session){

         return $this->render('session/showOne.html.twig', [
             'session' => $session ]);

     }

}
