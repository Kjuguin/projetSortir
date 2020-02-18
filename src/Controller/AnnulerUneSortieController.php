<?php

namespace App\Controller;

use App\Entity\Sortie;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/annuler", name="annuler_")
 */
class AnnulerUneSortieController extends AbstractController
{
    /**
     * @Route("/sortie/{id}", name="sortie")
     */
    public function annulerSortie($id, EntityManagerInterface $em, Request $request)
    {
        if (!($this->isGranted("ROLE_PARTICIPANT"))) {

            $this->addFlash('danger', 'Vous devez être connecter');

            return $this->redirectToRoute('app_login');
        }


            $SortieRepository = $this->getDoctrine()->getRepository(Sortie::class);
            $sortie = $SortieRepository->find($id);
            $nom = $sortie->getNom();

            $this->addFlash("succes", "Sortie " . $nom . " Annulé");
            $em->remove($sortie);
            $em->flush();

            return $this->redirectToRoute("home");

    }

    /**
     * @Route("/verification/{id}", name="verification")
     */
    public function annulerVerification($id, Request $request, EntityManagerInterface $em)
    {

        if (!($this->isGranted("ROLE_PARTICIPANT"))) {

            $this->addFlash('danger', 'Vous devez être connecter');

            return $this->redirectToRoute('app_login');
        }

        $sortieRepository = $em->getRepository(Sortie::class);
        $sortie = $sortieRepository->find($id);

        return $this->render('sortie/annulerSortie.html.twig', [
                'sortie' => $sortie
            ]
        );

    }
}
