<?php

namespace App\Controller;

use App\Entity\Site;
use App\Entity\Sortie;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/home/{recherche}", name="home")
     */
    public function index($recherche = null, EntityManagerInterface $em, Request $request)
    {

        if (!($this->isGranted("ROLE_PARTICIPANT"))) {

            $this->addFlash('danger', 'Vous devez vous connecter');

            return $this->redirectToRoute('app_login');
        }


        $siteRepository = $em->getRepository(Site::class);
        $sites = $siteRepository->findAll();

        if ($recherche != null) {
            $sortieRepository = $em->getRepository(Sortie::class);
            $inscrit = null;
            $notInscrit = null;

            if (!empty($request->get('filtre1'))) {
                $organisateur = $this->getUser()->getId();
            } else {
                $organisateur = null;
            }

            if (!empty($request->get('filtre2'))) {
                $inscrit = $this->getUser()->getId();
            }

            if (!empty($request->get('filtre3'))) {
                $notInscrit = $this->getUser()->getId();
            }

            $param = [
                "site" => $request->get('site'),
                "nom" => $request->get('nom'),
                "dateDebut" => $request->get('date-debut'),
                "dateFin" => $request->get('date-fin'),
                "organisateur" => $organisateur,
                "inscrit"=>$inscrit,
                "notInscrit"=>$notInscrit,
                "passee" => $request->get('filtre4')
            ];

            dump($param);

            $sorties = $sortieRepository->afficher($param);
        } else {
            $sorties = $em->getRepository(Sortie::class)->findAll();
        }

        return $this->render('home/home.html.twig',
            [
                "sites" => $sites,
                "sorties" => $sorties,
            ]
        );
    }

}
