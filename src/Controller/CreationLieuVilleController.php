<?php

namespace App\Controller;

use App\Entity\Lieu;
use App\Entity\Ville;
use App\Form\LieuType;
use App\Form\VilleType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CreationLieuVilleController extends AbstractController
{
    /**
     * @Route("/ajoutLieuVille", name="ajoutLieuVille")
     * @param EntityManagerInterface $em
     * @param Request $request
     * @return Response
     */
    public function form(EntityManagerInterface $em, Request $request)
    {
        $lieu = new Lieu();
        $ville = new Ville();

        $formLieu = $this->createForm(LieuType::class, $lieu);
        $formVille = $this->createForm(VilleType::class, $ville);

        $formLieu->handleRequest($request);
        $formVille->handleRequest($request);

        if ($formLieu->isSubmitted() && $formLieu->isValid()) {
            $this->addFlash("success", "lieu ajouté");

            $em->persist($lieu);

            if ($formVille->isSubmitted() && $formVille->isValid()) {
                $this->addFlash("success", "Ville ajoutée");
                $em->persist($ville);

            }

            $em->flush();

            return $this->redirectToRoute("ajoutLieuVille");
        }

        return $this->render('creation_lieu_ville/index.html.twig', [
            "formLieu" => $formLieu->createView(),
            "formVille" =>$formVille->createView()
        ]);

    }
}
