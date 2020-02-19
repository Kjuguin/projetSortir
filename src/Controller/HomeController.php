<?php

namespace App\Controller;

use App\Entity\Site;
use App\Entity\Sortie;
use App\Entity\TestUn;
use App\Entity\User;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\AnnotationLoader;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use function Sodium\add;

class HomeController extends AbstractController
{
    /**
     * @Route("/home/recherche", name="home_recherche")
     */
    public function index(EntityManagerInterface $em, Request $request)
    {
        $classMetadataFactory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));

        $normalizer = new ObjectNormalizer($classMetadataFactory);
        $serializer = new Serializer([new DateTimeNormalizer(),$normalizer ]);

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

//        $param = [
//            "site" => $request->get('site'),
//            "nom" => $request->get('nom'),
//            "dateDebut" => $request->get('date-debut'),
//            "dateFin" => $request->get('date-fin'),
//            "organisateur" => $organisateur,
//            "inscrit" => $inscrit,
//            "notInscrit" => $notInscrit,
//            "passee" => $request->get('filtre4')
//        ];

        $param = [
            "site" => $request->get('site'),
            "nom" => $request->get('nom'),
            "dateDebut" => $request->get('dateDebut'),
            "dateFin" => $request->get('dateFin'),
            "organisateur" => $organisateur,
            "inscrit" => $inscrit,
            "notInscrit" => $notInscrit,
            "passee" => $passee,
        ];

        $sorties = $sortieRepository->afficher($param);

        $data = $serializer->normalize($sorties, null, ['groups' => 'group1']);

        return $this->json(['sorties'=>$data, 'id' => $this->getUser()->getId()]);

    }

    /**
     * @Route("/home", name="home")
     */
    public function home(EntityManagerInterface $em, Request $request)
    {
        $siteRepository = $em->getRepository(Site::class);
        $sites = $siteRepository->findAll();


        $sortieRepository = $em->getRepository(Sortie::class);

        $sorties = $sortieRepository->findAll();

        return $this->render('home/home.html.twig',
            [
                "sites" => $sites,
                "sorties" => $sorties,
            ]
        );

    }

    //TODO pour modification de l'état
//CREATE DEFINER=root@localhost
//EVENT remplissageVille
//ON SCHEDULE EVERY 1 MINUTE STARTS '2020-02-14 18:44:00'
//ON COMPLETION PRESERVE ENABLE
//COMMENT 'Toutes les minutes, tous les personnages du jeu gagnent de l''XP.'
//DO
//BEGIN
//INSERT INTO ville (nom_ville, code_postal) VALUES ('test', 44444);
//END

//FOR EACH ROW BEGIN
//UPDATE `changelog` SET `old_value`=OLD.`field1`, `new_value`=NEW.`field1` WHERE `backup_tab`.`id`=`example_tab`.`id`
//END


}
