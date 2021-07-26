<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Announce;
use App\Form\CommentType;
use App\Repository\AnnounceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class AnnonceController extends AbstractController
{   
    // #[Route('/annonces', name: 'app_annonce')]
    // public function index(): Response
    // {
    //     //on appelle la liste des annonces 
    // //une autre façon d'utiliser les donnees de la BD
    //     $annonce = $this->getDoctrine()->getRepository(Announce::class)->findAll();
        
    //     return $this->render('annonce/index.html.twig', ['annonce' => $annonce]);
    // }



    private $repository;

    /**
    * var AnnounceRepository
    */
    public function __construct(AnnounceRepository $repo, EntityManagerInterface $manager)
    {
        $this->repository = $repo;
        $this->manager = $manager;
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

    
    /**
    * @Route("/annonces/{slug}", name="annonces.show", requirements={"slug": "[a-z0-9\-]*"})
    * @param Announce $annonce
    * @return Response
    */
    public function show(Announce $annonce, Request $request): Response
{

    $comment = new Comment();
    $form = $this->createForm(CommentType::class, $comment);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()){
        $em = $this->getDoctrine()->getManager();
        $annonce->addComment($comment);
        $em->persist($comment);
        $em->flush();
    
    

        return $this->redirectToRoute("annonces.show", [
            'slug' => $annonce->getSlug()
        ]);
    }
    return $this->render('annonce/show.html.twig', [
        'annonce' => $annonce,
        'form' => $form->createView()
    ]);


        // if ($annonce->getSlug() !== $slug) {
    //     return $this->redirectToRoute('annonces.show', [
    //         'id' => $annonce->getId(),
    //         'slug' => $annonce->getSlug()
    //     ], 301);
    // }
}
}