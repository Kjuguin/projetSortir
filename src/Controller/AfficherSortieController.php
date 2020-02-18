<?php

namespace App\Controller;

use App\Entity\Etat;
use App\Entity\Sortie;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Flex\Response;

/**
 * @Route("/sortie", name="sortie_",)
 */
class AfficherSortieController extends AbstractController
{
    /**
     * @Route("/afficherSortie/{id}", name="afficherSortie")
     */
    public function afficherSortie($id, Request $request, EntityManagerInterface $em)
    {

        if (!($this->isGranted("ROLE_PARTICIPANT"))) {

            $this->addFlash('danger', 'Vous devez être connecter');

            return $this->redirectToRoute('app_login');
        }

        $sortieRepository = $em->getRepository(Sortie::class);
        $sortie = $sortieRepository->find($id);

        return $this->render('sortie/afficherSortie.html.twig', [
                'sortie' => $sortie
            ]
        );
    }

    /**
     * @Route("/publier/{id}", name="publier")
     */
    public function publierSortie($id, Request $request, EntityManagerInterface $em)
    {

        if (!($this->isGranted("ROLE_PARTICIPANT"))) {

            $this->addFlash('danger', 'Vous devez être connecter');

            return $this->redirectToRoute('app_login');
        }

        $sortieRepository = $em->getRepository(Sortie::class);
        $sortie = $sortieRepository->find($id);

        $etatRepository = $em->getRepository(Etat::class);
        $etat = $etatRepository->findOneBy([
            'libelle' => 'Ouvert']);

        $sortie->setNoEtat($etat);

        $em->persist($sortie);
        $em->flush();

        return $this->redirectToRoute("home");
    }
}
