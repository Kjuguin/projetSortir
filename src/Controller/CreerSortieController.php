<?php

namespace App\Controller;

use App\Entity\Etat;
use App\Entity\Lieu;
use App\Entity\Site;
use App\Entity\User;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\UriSigner;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Sortie;
use App\Form\CreationSortieType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\AnnotationLoader;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;


class CreerSortieController extends AbstractController
{
    /**
     * @Route("/creerSortie/{token}", name="creer_sortie")
     */
    public function index($token = null, Request $request, EntityManagerInterface $em)
    {
        $request->get('nom');
        if (!($this->isGranted("ROLE_PARTICIPANT"))) {

            $this->addFlash('danger', 'Vous devez être connecté');

            return $this->redirectToRoute('app_login');
        }
        $sortie = new Sortie();
        if ($token) {
            $tab = explode(',', base64_decode($token));
            $lieu = $em->getRepository(Lieu::class)->find($tab[6]);
            dump($tab[6]);
            dump($lieu);

            dump($tab);

            if (!$tab[3]) {
                $tab[3] = 0;
            }

            if (!$tab[4]) {
                $tab[4] = 0;
            }

            $sortie->setNom($tab[0])
                ->setDateDebut(new \DateTime($tab[1]))
                ->setDateCloture(new \DateTime($tab[2]))
                ->setNbInscriptionMax($tab[3])
                ->setDuree($tab[4])
                ->setDescriptionInfos($tab[5])
                ->setNoLieu($lieu);

        }
        $form = $this->createForm(CreationSortieType::class, $sortie);
        $form->handleRequest($request);

        $currentUser = $this->getUser();
        $currentSite = $this->getUser()->getNoSite();
        $sortie = $sortie->setNoSite($em->getRepository(Site::class)->find($currentSite));

        $sortie = $sortie->setNoOrganisateur($currentUser);

        $valueInput = $request->get("sortie");


        if ($valueInput == 1) {
            $sortie->setNoEtat($em->getRepository(Etat::class)->findOneBy(array('libelle' => 'En création')));
        } else {
            $sortie->setNoEtat($em->getRepository(Etat::class)->findOneBy(array('libelle' => 'Ouvert')));
        }

        if ($form->isSubmitted() && $form->isValid()) {

            $this->addFlash("success", "Sortie ajoutée");
            $em->persist($sortie);
            $em->flush();
            return $this->redirectToRoute("home");

        }

        return $this->render('sortie/creerModifierSortie.html.twig', [
            "form" => $form->createView(),
            "modification" => 0,
            "sortie" => null
        ]);
    }


    /**
     * @Route("/creerSortie/lieu/{id}", name="lieu")
     */
    public function lieu($id, Request $request, EntityManagerInterface $em)
    {
        if (!($this->isGranted("ROLE_PARTICIPANT"))) {

            $this->addFlash('danger', 'Vous devez être connecté');

            return $this->redirectToRoute('app_login');
        }

        $classMetadataFactory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));

        $normalizer = new ObjectNormalizer($classMetadataFactory);
        $serializer = new Serializer([new DateTimeNormalizer(), $normalizer]);

        $lieuRepository = $em->getRepository(Lieu::class);

        $lieu = $lieuRepository->find($id);

        $data = $serializer->normalize($lieu, null, ['groups' => 'groupe2']);

        return $this->json(['lieu' => $data]);
    }
}
