<?php

namespace App\Controller;

use App\Entity\Announce;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AnnonceController extends AbstractController
{
    #[Route('/annonce', name: 'annonce')]
    public function index(): Response
    {
        //on appelle la liste des annonces
        $annonce = $this->getDoctrine()->getRepository(Announce::class)->findAll();
        
        return $this->render('annonce/index.html.twig', ['annonce' => $annonce]);
    }
}
