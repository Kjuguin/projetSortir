<?php

namespace App\Controller;

use App\Entity\Inscription;
use App\Entity\Sortie;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class InscrireController extends AbstractController
{

    /**
     * @Route("/inscription/{id}", name="inscription")
     */
    public function inscription($id, EntityManagerInterface $entityManager)
    {
        if (!($this->isGranted("ROLE_PARTICIPANT"))) {

            $this->addFlash('danger', 'Vous devez être connecter');

            return $this->redirectToRoute('app_login');
        }

        $SortieRepository = $this->getDoctrine()->getRepository(Sortie::class);
        $sortie = $SortieRepository->find($id);
        $date = new \DateTime();
        $participant = $this->getUser();
        $inscription = new Inscription();


        if (count($sortie->getNoInscriptions()) < $sortie->getNbInscriptionMax()) {

            $inscription->setDateInscription($date);
            $inscription->setNoUser($participant);
            $inscription->setNoSortie($sortie);
            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->persist($inscription);
            $entityManager->flush();

        } else {
            $this->addFlash('danger', "il n'y a plus de place pour cette sortie !");
        }

        return $this->redirectToRoute('home');
    }

    /**
     * @Route("desistement/{id}", name="desistement")
     */
    public function desistement($id, EntityManagerInterface $em, Request $request)
    {

        if (!($this->isGranted("ROLE_PARTICIPANT"))) {

            $this->addFlash('danger', 'Vous devez être connecter');

            return $this->redirectToRoute('app_login');
        }


            $sortieRepository = $em->getRepository(Sortie::class);
            $sortie = $sortieRepository->find($id);

            $user = $this->getUser();

            $inscriptionRepository = $em->getRepository(Inscription::class);
            $inscription = $inscriptionRepository->findBy(
                array('noSortie' => $sortie, 'noUser' => $user)
            );

            $nom = $sortie->getNom();

            $this->addFlash("succes", "Vous etes bien desisté de la sortie " . $nom);

            // le findby renvoie un tableau alors il faut récuperer le premier élément
            $em->remove($inscription[0]);
            $em->flush();

            return $this->redirectToRoute("home");


    }
}
