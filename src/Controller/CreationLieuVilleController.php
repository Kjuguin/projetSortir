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


        $form = $this->createForm(LieuType::class, $lieu);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            $form->get('noVille');

            $this->addFlash("success", "lieu ajouté");
            $em->persist($lieu);
            $em->persist($ville);
            $em->flush();
            return $this->redirectToRoute("creation_sortie");
        }

        return $this->render('creation_lieu_ville/index.html.twig', [
            "form" => $form->createView()]);

    }
}
