<?php

namespace App\Controller;

use App\Entity\Inscription;
use App\Entity\Sortie;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SortieController extends AbstractController
{
    /**
     * @Route("/afficherSortie/{id}", name="afficherSortie", requirements={"id": "\d+"})
     * @param int $id
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function afficherSortie($id, Request $request, EntityManagerInterface $em)
    {
        dump($id);

        $sortieRepository = $em->getRepository(Sortie::class);
        $sortie = $sortieRepository->find($id);
        dump($sortie);
        return $this->render('sortie/afficherSortie.html.twig', [
            'sortie'=>$sortie
            ]
        );

    }

}
