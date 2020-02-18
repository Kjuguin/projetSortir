<?php

namespace App\Controller;

use App\Entity\Inscription;
use App\Entity\Sortie;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class InscrireController extends AbstractController
{

    /**
     * @Route("/inscription/{id}", name="inscription")
     */
    public function inscription($id, EntityManagerInterface $entityManager)
    {
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
}
