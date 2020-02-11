<?php

namespace App\Controller;


use App\Entity\Session;
use App\Entity\Contenir;
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
     * @Route("/{id}", name="show_one_session", methods="GET")
     */
     public function showOne(Session $session, Contenir $contenir){

         return $this->render('session/showOne.html.twig', ['session' => $session]);
     }

}
