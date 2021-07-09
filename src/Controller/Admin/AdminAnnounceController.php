<?php

namespace App\Controller\Admin;



use App\Entity\Announce;
use App\Entity\Image;
use App\Form\AnnounceType;
use App\Repository\AnnounceRepository;
use Doctrine\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\Loader\Configurator\form;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;



class AdminAnnounceController extends AbstractController
{

    private $repository;
    public function __construct(AnnounceRepository $repository, EntityManagerInterface $manager)
    {
        $this->repository = $repository;
        $this->manager = $manager;
    }
    /**
     * @Route("annonces/admin", name="annonces.admin.index")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index()
    {
        $annonces = $this->repository->findAll();
        //$form = $this->createForm(AnnounceType::class, $annonces);
        //$form->handleRequest($request);
        return ($this->render('admin_announce/index.html.twig', compact('annonces')));

        // return $this->render('admin_announce/index.html.twig', [

        //     'annonces' => $annonces

        // ]);
    }

    #[Route('/annonces/create', name: 'annonces.create')]
    public function create(Request $request, EntityManagerInterface $manager): Response
    {
        $annonce = new Announce();
        $form = $this->createForm(AnnounceType::class, $annonce);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // Récupération de l'image depuis le formulaire
            // dd($request);
            $ImageCover = $form->get('imageCover')->getData();
            
            if ($ImageCover) {
                //création d'un nom pour l'image avec l'extension récupérée
                $imageName = md5(uniqid()) . '.' . $ImageCover->guessExtension();

                //on déplace l'image dans le répertoire cover_image_directory avec le nom qu'on nn$annonce crée
                $ImageCover->move(
                    $this->getParameter('cover_image_directory'),
                    $imageName
                );

                // on enregistre le nom de l'image dans la base de données
                $annonce->setImageCover($imageName);
            }

            $images = $form->get('images')->getData();
            // on boucle sur les images
            foreach( $images as $image){
                // on génere un nouveau fichier
                $fichier = md5(uniqid()) . '.' . $image->guessExtension();
                //on déplace l'image dans le répertoire cover_image_directory avec le nom qu'on nn$annonce crée
                $image->move(
                    $this->getParameter('images_directory'),
                    $fichier
                );

                // on enregistre le nom de l'image dans la base de données
                $img = new Image();
                $img->setImageUrl($fichier);
                $img->setDescription_img('description');
                $annonce->addImage($img);
    
            }
            $manager->persist($annonce);
            $manager->flush();

            return $this->redirectToRoute('app_annonces');
        }

        return $this->render('admin_announce/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("annonces/admin/{id}", name="annonces.admin.edit")
     * @param Announce $annonces
     * @param Request $request
     * @return Response
     */
    public function edit(Announce $annonce, Request $request)
    {
        $form = $this->createForm(AnnounceType::class, $annonce);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Récupération de l'image depuis le formulaire
            // dd($request);
            $ImageCover = $form->get('imageCover')->getData();
            if ($ImageCover) {
                //création d'un nom pour l'image avec l'extension récupérée
                $imageName = md5(uniqid()) . '.' . $ImageCover->guessExtension();

                //on déplace l'image dans le répertoire cover_image_directory avec le nom qu'on a crée
                $ImageCover->move(
                    $this->getParameter('cover_image_directory'),
                    $imageName
                );

                // on enregistre le nom de l'image dans la base de données
                $annonce->setImageCover($imageName);
            }
            $this->manager->persist($annonce);
            $this->manager->flush();

            return $this->redirectToRoute('app_annonces');
        }
        

        return $this->render('admin_announce/edit.html.twig', [
           // 'annonce' => $annonce,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("annonces/admin/{id}/delete", name="annonces.admin.delete")
     * @param Announce $annonce
     * @return RedirectResponse
     */
    public function delete(Announce $annonce): RedirectResponse
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($annonce);
        $em->flush();

        return $this->redirectToRoute("annonces.admin.index");
    }


}
