<?php

namespace App\Controller;

use App\Entity\Sortie;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AnnulerUneSortieController extends AbstractController
{
    /**
     * @Route("annulerSortie/{id}", name="annulerSortie")
     */
    public function annulerSortie($id, EntityManagerInterface $em, Request $request)
    {
        {
            $SortieRepository = $this->getDoctrine()->getRepository(Sortie::class);
            $sortie = $SortieRepository->find($id);
            $nom = $sortie->getNom();

            $this->addFlash("succes", "Sortie " . $nom . " Annulé");
            $em->remove($sortie);
            $em->flush();

            return $this->redirectToRoute("home");
        }
    }

    /**
     * @Route("annulerSortieTwig/{id}", name="annulerSortieTwig")
     */
    public function annulerSortietwig($id, Request $request, EntityManagerInterface $em)
    {

        $sortieRepository = $em->getRepository(Sortie::class);
        $sortie = $sortieRepository->find($id);

        return $this->render('sortie/annulerSortie.html.twig', [
                'sortie' => $sortie
            ]
        );

    }
}
