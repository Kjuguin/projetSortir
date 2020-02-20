<?php

namespace App\Controller;

use App\Entity\Lieu;
use App\Entity\Site;
use App\Form\AjoutSiteType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class GererSiteLieuController extends AbstractController
{
    /**
     * @Route("/gererSite", name="gererSite")
     */
    public function gererSite(Request $request, EntityManagerInterface $em)
    {

        if (!($this->isGranted("ROLE_ADMIN"))) {

            $this->addFlash('danger', 'Vous devez être Admin ');

            return $this->redirectToRoute('app_login');
        }



        $ajoutsite = new Site();

        $ajoutSiteForm = $this->createForm(AjoutSiteType::class, $ajoutsite);
        $ajoutSiteForm->handleRequest($request);


        if ($ajoutSiteForm->isSubmitted() && $ajoutSiteForm->isValid()) {

            $this->addFlash("success", "Sortie ajoutée");
            $em->persist($ajoutsite);
            $em->flush();



        }

        $siteRepository = $em->getRepository(Site::class);
        $sites = $siteRepository->findAll();

        return $this->render('site/gererLesSites.html.twig', [
                'sites' => $sites,
                "ajoutSiteForm" => $ajoutSiteForm->createView(),]
        );

    }
    /**
     * @Route("/supprimerSite/{id}", name="supprimerSite")
     */
    public function supprimerSite($id, EntityManagerInterface $em, Request $request)
    {
        if (!($this->isGranted("ROLE_ADMIN"))) {

            $this->addFlash('danger', 'Vous devez être connecté');

            return $this->redirectToRoute('app_login');
        }


        $siteRepository = $this->getDoctrine()->getRepository(Site::class);
        $site = $siteRepository->find($id);
        $nom = $site->getNomSite();

        $this->addFlash("succes", "Site" . $nom . " Supprimer");
        $em->remove($site);
        $em->flush();

        return $this->redirectToRoute("gererSite");

    }

    /**
     * @Route("/gererLieu", name="gererLieu")
     */
    public function gererLieu(Request $request, EntityManagerInterface $em)
    {

        if (!($this->isGranted("ROLE_ADMIN"))) {

            $this->addFlash('danger', 'Vous devez être Admin ');

            return $this->redirectToRoute('app_login');
        }

        $lieuRepository = $em->getRepository(Lieu::class);
        $lieu = $lieuRepository->findAll();

        return $this->render('lieu/gererLesLieux.html.twig', [
                'lieu' => $lieu,]
        );

    }
    /**
     * @Route("/supprimerLieu/{id}", name="supprimerLieu")
     */
    public function supprimerLieu($id, EntityManagerInterface $em, Request $request)
    {
        if (!($this->isGranted("ROLE_ADMIN"))) {

            $this->addFlash('danger', 'Vous devez être connecté');

            return $this->redirectToRoute('app_login');
        }


        $lieuRepository = $this->getDoctrine()->getRepository(Lieu::class);
        $lieu = $lieuRepository->find($id);
        $nom = $lieu->getNomLieu();

        $this->addFlash("succes", "Lieu" . $nom . " Supprimer");
        $em->remove($lieu);
        $em->flush();

        return $this->redirectToRoute("gererLieu");

    }


}
