<?php

namespace App\Controller;


use App\Entity\Site;
use App\Entity\Sortie;
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

class HomeController extends AbstractController
{
    /**
     * @Route("/recherche", name="home_recherche")
     */
    public function index(EntityManagerInterface $em, Request $request)
    {

        if (!($this->isGranted("ROLE_PARTICIPANT"))) {

            $this->addFlash('danger', 'Vous devez être connecté');

            return $this->redirectToRoute('app_login');
        }

        $classMetadataFactory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));

        $normalizer = new ObjectNormalizer($classMetadataFactory);
        $serializer = new Serializer([new DateTimeNormalizer(), $normalizer]);

        $sortieRepository = $em->getRepository(Sortie::class);

        if (!empty($request->get('organisateur'))) {
            $organisateur = $this->getUser()->getId();
        } else {
            $organisateur = null;
        }

        if (!empty($request->get('inscrit'))) {
            $inscrit = $this->getUser()->getId();
        } else {
            $inscrit = null;
        }

        if (!empty($request->get('notInscrit'))) {
            $notInscrit = $this->getUser()->getId();
        } else {
            $notInscrit = null;
        }

        if (!empty($request->get('passee'))) {
            $passee = new \DateTime();
        } else {
            $passee = null;
        }

        $param = [
            "site" => $request->get('site'),
            "nom" => $request->get('nom'),
            "dateDebut" => $request->get('dateDebut'),
            "dateFin" => $request->get('dateFin'),
            "organisateur" => $organisateur,
            "inscrit" => $inscrit,
            "notInscrit" => $notInscrit,
            "passee" => $passee,
            "sens" => 'DESC',
        ];

        $sorties = $sortieRepository->afficher($param);

        $data = $serializer->normalize($sorties, null, ['groups' => 'group1']);

        return $this->json(['sorties' => $data, 'id' => $this->getUser()->getId()]);

    }

    /**
     * @Route("/", name="home")
     */
    public function home(EntityManagerInterface $em, Request $request)
    {
        if (!($this->isGranted("ROLE_PARTICIPANT"))) {

            $this->addFlash('danger', 'Vous devez être connecté');

            return $this->redirectToRoute('app_login');
        }

        $siteRepository = $em->getRepository(Site::class);
        $sites = $siteRepository->findAll();


        $sortiesRepository = $em->getRepository(Sortie::class);

        $date = new \DateTime();
        $date->format('Y-m-d H:i:s');

        $param = [
            "site" => null,
            "nom" => null,
            "dateDebut" => '2020-02-19',
            "dateFin" => null,
            "organisateur" => null,
            "inscrit" => null,
            "notInscrit" => null,
            "passee" => null,
            "sens" => 'ASC',
        ];


        $sorties = $sortiesRepository->afficher($param);
        $sortie = $sorties[0];

        return $this->render('home/home.html.twig',
            [
                "sites" => $sites,
                "heure" => $sortie->getDateDebut()
            ]
        );

    }

}
