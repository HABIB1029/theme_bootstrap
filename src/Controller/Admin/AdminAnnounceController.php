<?php

namespace App\Controller\Admin;


use App\Entity\Announce;
use App\Repository\AnnounceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\AnnounceType;
use Symfony\Component\HttpFoundation\Response;



class AdminAnnounceController extends AbstractController
{
    public function __construct(AnnounceRepository $repository)
    {
        $this->repository=$repository;

}
/**
 * @Route("/admin", name="admin.annonce.index")
 * @return \Symfony\Component\HttpFoundation\Response
 */
public function index()
{
    $annonces = $this->repository->findAll();
    return ($this->render('admin_announce/index.html.twig', compact('annonces')));

    // return $this->render('admin_announce/index.html.twig', [

    //     'annonces' => $annonce 
       
    // ]);
}

/**
 * @Route("/admin/{id}", name="admin.annonce.edit")
 * @return \Symfony\Component\HttpFoundation\Response
 */
public function edit(Announce $annonce) : Response
{   
    $annonce = new Announce();
    $form = $this->createForm(AnnounceType::class, $annonce);
   
    return $this->render('admin_announce/edit.html.twig', [

       'annonce' => $annonce ,
        'form' => $form->createView()
    ]);
}


}