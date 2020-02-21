<?php

namespace App\Controller;


use App\Entity\Etat;
use App\Entity\Site;
use App\Entity\Sortie;
use App\Entity\User;
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


        $dateDuJour = new \DateTime('now');


        $verifSorties = $em->getRepository(Sortie::class)->findAll();

//        foreach ($verifSorties as $verif) {
//            if ($verif->getNoEtat()->getLibelle() != Etat::ANNULE && $verif->getNoEtat()->getLibelle() != Etat::ARCHIVE) {
//
//                $etat = null;
//                $dateFin = clone $verif->getDateDebut();
//                $dure = $verif->getDuree();
//
//                $interval = 'PT' . $dure . 'M';
//                $dateFin = $dateFin->add(new \DateInterval($interval));
//                dump($dateFin);
//                $intervalle = date_diff($dateDuJour, $dateFin);
//
//                if ($intervalle->days > 30 && $dateDuJour > $dateFin) {
//                    dump($intervalle->days);
//                    dump($dateDuJour);
//                    $etat = $em->getRepository(Etat::class)->findOneBy(['libelle' => Etat::ARCHIVE]);
//                    $verif->setNoEtat($etat);
//                } elseif ($dateDuJour > $dateFin) {
//                    $etat = $em->getRepository(Etat::class)->findOneBy(['libelle' => Etat::TERMINE]);
//                    $verif->setNoEtat($etat);
//                } elseif ($dateDuJour < $dateFin && $dateDuJour > $verif->getDateDebut()) {
//                    $etat = $em->getRepository(Etat::class)->findOneBy(['libelle' => Etat::COURS]);
//                    $verif->setNoEtat($etat);
//                } elseif ($dateDuJour > $verif->getDateCloture() && $dateDuJour < $verif->getDateDebut()) {
//                    $etat = $em->getRepository(Etat::class)->findOneBy(['libelle' => Etat::CLOTURE]);
//                    $verif->setNoEtat($etat);
//                } else {
//                    $etat = $em->getRepository(Etat::class)->findOneBy(['libelle' => Etat::OUVERT]);
//                    $verif->setNoEtat($etat);
//                }
//
//                $em->persist($verif);
//            }
//
//        }

        $em->flush();


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

        $dateDuJour = new \DateTime('now');


        $verifSorties = $em->getRepository(Sortie::class)->findAll();

//        if ($verifSorties) {
//            dump($verifSorties);
//
//            foreach ($verifSorties as $verif) {
//                if ($verif->getNoEtat()->getLibelle() != Etat::ANNULE && $verif->getNoEtat()->getLibelle() != Etat::ARCHIVE) {
//
//                    $etat = null;
//                    $dateFin = clone $verif->getDateDebut();
//                    $dure = $verif->getDuree();
//
//                    $interval = 'PT' . $dure . 'M';
//                    $dateFin = $dateFin->add(new \DateInterval($interval));
//                    $intervalle = date_diff($dateDuJour, $dateFin);
//
//                    if ($intervalle->days > 30 && $dateDuJour > $dateFin) {
//                        dump($intervalle->days);
//                        dump($dateDuJour);
//                        $etat = $em->getRepository(Etat::class)->findOneBy(['libelle' => Etat::ARCHIVE]);
//                        $verif->setNoEtat($etat);
//                    } elseif ($dateDuJour > $dateFin) {
//                        $etat = $em->getRepository(Etat::class)->findOneBy(['libelle' => Etat::TERMINE]);
//                        $verif->setNoEtat($etat);
//                    } elseif ($dateDuJour < $dateFin && $dateDuJour > $verif->getDateDebut()) {
//                        $etat = $em->getRepository(Etat::class)->findOneBy(['libelle' => Etat::COURS]);
//                        $verif->setNoEtat($etat);
//                    } elseif ($dateDuJour > $verif->getDateCloture() && $dateDuJour < $verif->getDateDebut()) {
//                        $etat = $em->getRepository(Etat::class)->findOneBy(['libelle' => Etat::CLOTURE]);
//                        $verif->setNoEtat($etat);
//                    } else {
//                        $etat = $em->getRepository(Etat::class)->findOneBy(['libelle' => Etat::OUVERT]);
//                        $verif->setNoEtat($etat);
//                    }
//
//                    $em->persist($verif);
//                }
//
//            }
//        }
        $em->flush();

        $sortiesRepository = $em->getRepository(Sortie::class);

        $dateTime = new \DateTime();
        $date = $dateTime->format('Y-m-d H:i:s');
        $param = ["site" => null,
            "nom" => null,
            "dateDebut" => $date,
            "dateFin" => null,
            "organisateur" => null,
            "inscrit" => $this->getUser()->getId(),
            "notInscrit" => null,
            "passee" => null,
            "sens" => 'ASC',];


        $sorties = $sortiesRepository->afficher($param);
        if ($sorties) {
            $heure = $sorties[0]->getDateDebut();
        } else {
            $heure = null;
        }
        dump($heure);
        return $this->render('home/home.html.twig',
            ["sites" => $sites,
                "heure" => $heure]
        );

    }

    /**
     * @Route("/troll", name="troll")
     */
    public function troll(EntityManagerInterface $em, Request $request)
    {
        if (!($this->isGranted("ROLE_PARTICIPANT"))) {

            $this->addFlash('danger', 'Vous devez être connecté');

            return $this->redirectToRoute('app_login');
        }

        $avatarsRepository = $em->getRepository(User::class);


        $avatar = $avatarsRepository->findAll();


        return $this->render('troll.html.twig',
            ["avatars" => $avatar]
        );

    }
}
