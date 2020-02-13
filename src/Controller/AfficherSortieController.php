<?php

namespace App\Controller;

use App\Entity\Sortie;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Flex\Response;

class AfficherSortieController extends AbstractController
{
    /**
     * @Route("/afficherSortie/{id}", name="afficherSortie", requirements={"id": "\d+"})
     */
    public function afficherSortie($id, Request $request, EntityManagerInterface $em)
    {

        $sortieRepository = $em->getRepository(Sortie::class);
        $sortie = $sortieRepository->find($id);

        return $this->render('afficherSortie.html.twig', [
                'sortie' => $sortie
            ]
        );

    }
}
