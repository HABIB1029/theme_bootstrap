<?php

namespace App\Controller;

use App\Entity\Announce;
use App\Repository\AnnounceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter; 
use Symfony\Component\Routing\Annotation\Route;

class AnnonceController extends AbstractController
{   
    // #[Route('/annonces', name: 'app_annonce')]
    // public function index(): Response
    // {
    //     //on appelle la liste des annonces 
    // //une autre d'utiliser les donnees de la BD
    //     $annonce = $this->getDoctrine()->getRepository(Announce::class)->findAll();
        
    //     return $this->render('annonce/index.html.twig', ['annonce' => $annonce]);
    // }



    private $repository;

    /**
    * var AnnounceRepository
    */
    public function __construct(AnnounceRepository $repo)
    {
        $this->repository = $repo;
    }

    /**
    * @Route("/annonces", name="app_annonces")
    */
    public function index(): Response
    {

       $annonce = $this->repository->findAll();

        return $this->render('annonce/index.html.twig', [

            'annonces' => $annonce 
           
        ]);
    }

    
    // public function show(Announce $annonce): Response
    // {
       
    //     // $annonce = $this->repository->findOneBy($title);
    //     return $this->render('annonce/show.html.twig', [

    //         'annonces' => $annonce
           
    //     ]);
    // }
    /**
    * @Route("/annonces/{slug}-{id}", name="annonces.show", requirements={"slug": "[a-z0-9\-]*"})
    * @param Property $property
    * @return Response
    */
    public function show(Announce $annonce, string $slug): Response
{
    if ($annonce->getSlug() !== $slug) {
        return $this->redirectToRoute('annonce.show', [
            'id' => $annonce->getId(),
            'slug' => $annonce->getSlug()
        ], 301);
    }
    return $this->render('annonce/show.html.twig', [
        'annonce' => $annonce
    ]);
}
}
