<?php

namespace App\Controller;

use App\Entity\Site;
use App\Entity\Sortie;
use App\Entity\TestUn;
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
//        $encoder = new JsonEncoder();
//        $defaultContext = [
//            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($object, $format, $context) {
//                return 'circ
//                ';
//            },
//        ];
//        $normalizer = new ObjectNormalizer(null, null, null, null, null, null, $defaultContext);
//
//        $serializer = new Serializer([$normalizer], [$encoder]);

//        $sortieRepository = $em->getRepository(Sortie::class);

        $classMetadataFactory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));

        $normalizer = new ObjectNormalizer($classMetadataFactory);
        $serializer = new Serializer([new DateTimeNormalizer(),$normalizer ]);

        $sortieRepository = $em->getRepository(Sortie::class);

        if (!empty($request->get('filtre1'))) {
            $organisateur = $this->getUser()->getId();
        } else {
            $organisateur = null;
        }

        if (!empty($request->get('filtre2'))) {
            $inscrit = $this->getUser()->getId();
        } else {
            $inscrit = null;
        }

        if (!empty($request->get('filtre3'))) {
            $notInscrit = $this->getUser()->getId();
        } else {
            $notInscrit = null;
        }

        $param = [
            "site" => $request->get('site'),
            "nom" => $request->get('nom'),
            "dateDebut" => $request->get('date-debut'),
            "dateFin" => $request->get('date-fin'),
            "organisateur" => $organisateur,
            "inscrit" => $inscrit,
            "notInscrit" => $notInscrit,
            "passee" => $request->get('filtre4')
        ];

        $sorties = $sortieRepository->afficher($param);

//        $json = $serializer->serialize($sorties, 'json');
//        dump($json);
//
//        return new JsonResponse($json, Response::HTTP_OK, [], true);
        $data = $serializer->normalize($sorties, null, ['groups' => 'group1']);

        dump($sorties);
        dump($data);
        die();
        return $this->json(['sorties'=>$data]);

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






//    /**
//     * @Route("/home/{recherche}", name="home")
//     */
//    public function index($recherche = null, EntityManagerInterface $em, Request $request)
//    {
//        $siteRepository = $em->getRepository(Site::class);
//        $sites = $siteRepository->findAll();
//
//        if ($recherche != null) {
//            $sortieRepository = $em->getRepository(Sortie::class);
//            $inscrit = null;
//            $notInscrit = null;
//
//            if (!empty($request->get('filtre1'))) {
//                $organisateur = $this->getUser()->getId();
//            } else {
//                $organisateur = null;
//            }
//
//            if (!empty($request->get('filtre2'))) {
//                $inscrit = $this->getUser()->getId();
//            }
//
//            if (!empty($request->get('filtre3'))) {
//                $notInscrit = $this->getUser()->getId();
//            }
//
//            $param = [
//                "site" => $request->get('site'),
//                "nom" => $request->get('nom'),
//                "dateDebut" => $request->get('date-debut'),
//                "dateFin" => $request->get('date-fin'),
//                "organisateur" => $organisateur,
//                "inscrit"=>$inscrit,
//                "notInscrit"=>$notInscrit,
//                "passee" => $request->get('filtre4')
//            ];
//
//            dump($param);
//
//            $sorties = $sortieRepository->afficher($param);
//        } else {
//            $sorties = $em->getRepository(Sortie::class)->findAll();
//        }
//
//        return $this->render('home/home.html.twig',
//            [
//                "sites" => $sites,
//                "sorties" => $sorties,
//            ]
//        );
//    }

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
