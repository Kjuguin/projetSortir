<?php

namespace App\Controller;

use App\Entity\Lieu;
use App\Entity\Site;
use App\Form\AjoutSiteType;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\AnnotationLoader;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class GererSiteLieuController extends AbstractController
{
    /**
     * @Route("/gererSite", name="gererSite")
     */
    public function gererSite(Request $request, EntityManagerInterface $em)
    {

        if (!($this->isGranted("ROLE_ADMIN"))) {

            $this->addFlash('danger', 'Vous devez être Admin ');

            return $this->redirectToRoute('home');
        }
        $ajoutsite = new Site();

        $ajoutSiteForm = $this->createForm(AjoutSiteType::class, $ajoutsite);
        $ajoutSiteForm->handleRequest($request);

        if ($ajoutSiteForm->isSubmitted() && $ajoutSiteForm->isValid()) {
            $ajoutsite->setEtat('OK');
            $this->addFlash("success", "Sortie ajoutée");
            $em->persist($ajoutsite);
            $em->flush();
        }

        $siteRepository = $em->getRepository(Site::class);
        $sites = $siteRepository->findBy(['etat'=>'OK']);

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

            return $this->redirectToRoute('home');
        }


        $siteRepository = $em->getRepository(Site::class);
        $site = $siteRepository->find($id);
        $nom = $site->getNomSite();
$site->setEtat('KO');
        $this->addFlash("succes", "Site" . $nom . " Supprimer");
        $em->remove($site);
        $em->flush();

        return $this->redirectToRoute("gererSite");

    }

    /**
     * @Route("/gererSite/recherche", name="site_recherche")
     */
    public function rechercheSite(EntityManagerInterface $em, Request $request)
    {
        if (!($this->isGranted("ROLE_ADMIN"))) {
            $this->addFlash('danger', 'Vous devez être connecté');
            return $this->redirectToRoute('home');
        }

        $classMetadataFactory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));
        $normalizer = new ObjectNormalizer($classMetadataFactory);
        $serializer = new Serializer([new DateTimeNormalizer(), $normalizer]);


        $siteRepository = $em->getRepository(Site::class);
        $sites = $siteRepository->afficherSite($request->get('nom'));

        $data = $serializer->normalize($sites, null, ['groups' => 'groupe3']);

        return $this->json(['sites' => $data]);
    }

    /**
     * @Route("/gererLieu", name="gererLieu")
     */
    public function gererLieu(Request $request, EntityManagerInterface $em)
    {

        if (!($this->isGranted("ROLE_ADMIN"))) {

            $this->addFlash('danger', 'Vous devez être Admin ');

            return $this->redirectToRoute('home');
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

            return $this->redirectToRoute('home');
        }


        $lieuRepository = $this->getDoctrine()->getRepository(Lieu::class);
        $lieu = $lieuRepository->find($id);
        $nom = $lieu->getNomLieu();

        $this->addFlash("succes", "Lieu" . $nom . " Supprimer");
        $em->remove($lieu);
        $em->flush();

        return $this->redirectToRoute("gererLieu");

    }

    /**
     * @Route("/gererLieu/recherche", name="lieu_recherche")
     */
    public function rechercheLieu(EntityManagerInterface $em, Request $request)
    {
        if (!($this->isGranted("ROLE_ADMIN"))) {
            $this->addFlash('danger', 'Vous devez être connecté');
            return $this->redirectToRoute('home');
        }

        $classMetadataFactory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));
        $normalizer = new ObjectNormalizer($classMetadataFactory);
        $serializer = new Serializer([new DateTimeNormalizer(), $normalizer]);


        $lieuRepository = $em->getRepository(Lieu::class);
        $lieux = $lieuRepository->afficherLieu($request->get('nom'));

        $data = $serializer->normalize($lieux, null, ['groups' => 'groupe4']);


        return $this->json(['sites' => $data]);
    }

}
