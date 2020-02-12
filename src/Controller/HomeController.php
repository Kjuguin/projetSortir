<?php

namespace App\Controller;

use App\Entity\Site;
use App\Entity\Sortie;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use function Sodium\add;

class HomeController extends AbstractController
{
    /**
     * @Route("/home/{recherche}", name="home")
     */
    public function index($recherche = null, EntityManagerInterface $em, Request $request)
    {
        $siteRepository = $em->getRepository(Site::class);
        $sites = $siteRepository->findAll();

        $sorties=[];

        if ( $recherche !=null){
            $sortieRepository = $em->getRepository(Sortie::class);

        // TODO : A décommenter avec le merge et les fichiers login
//            if(!empty($request->get('filtre1'))){
//                $organisateur = $this->getUser()->getId();
//            }

            // TODO
//            if(!empty($request->get('filtre2'))){
//                $inscrit = $this->getUser()->getId();
//            }
//             TODO
//            if(!empty($request->get('filtre3'))){
//                $notInscrit = $this->getUser()->getId();
//            }

            $param=[
                "site"=>$request->get('site'),
                "nom"=>$request->get('nom'),
                "dateDebut"=>$request->get('date-debut'),
                "dateFin"=>$request->get('date-fin'),
                // TODO
//                "organisateur"=>$organisateur,
//                "inscrit"=>$inscrit,
//                "notInscrit"=>$notInscrit,
                "passee"=>$request->get('filtre4')
            ];

            dump($param);

            $sorties = $sortieRepository->afficher($param);
        }

        return $this->render('home/home.html.twig',
            [
                "sites"=>$sites,
                "sorties" => $sorties
                ]
        );
    }

}
