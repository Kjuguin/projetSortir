<?php

namespace App\Controller;

use App\Entity\Sites;
use App\Entity\Sorties;
use App\Form\FiltreSortieHomeType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
//    /**
//     * @Route("/home", name="home")
//     */
//    public function index(EntityManagerInterface $em)
//    {
//        $siteRepository = $em->getRepository(Sites::class);
//        $sites = $siteRepository->findAll();
//
//        return $this->render('home/index.html.twig',
//            [
//            "sites"=>$sites
//            ]
//        );
//    }

    /**
     * @Route("/home", name="home")
     */
    public function index()
    {


        return $this->render('home/index.html.twig'
        );
    }


//    /**
//     * @Route("/home", name="home")
//     */
//    public function form(Request $request, EntityManagerInterface $em)
//    {
//        $sortie = new Sorties();
//        $sortieForm = $this->createForm(FiltreSortieHomeType::class, $sortie);
//
//        $sortieForm->handleRequest($request);
//        if($sortieForm->isSubmitted()){
//
//            $em->persist($sortie);
//            $em->flush;
//
//            return $this->redirectToRoute("home");
//        }
//
//        return $this->render("home/index.html.twig", [
//            "sortieForm"=>$sortieForm->createView()
//        ]);
//    }


}
