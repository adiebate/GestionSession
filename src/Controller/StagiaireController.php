<?php

namespace App\Controller;

use App\Entity\Stagiaire;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class StagiaireController extends AbstractController
{
   /**
     * @Route("/stagiaire", name="stagiare")
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
    * @Route("stagiaire/{id}", name="showOne_stagiaire")
    */
    public function showOne(Stagiaire $stagiaire){
        return $this->render('stagiaire/showOne.html.twig', ['stagiaire' => $stagiaire]
        );
    }
}
