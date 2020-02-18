<?php

namespace App\Controller;

use App\Entity\Etat;
use App\Entity\Sortie;
use App\Form\CreationSortieType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ModifierSortieController extends AbstractController
{
    /**
     * @Route("/modifierSortie/{id}", name="modifierSortie", requirements={"id"="\d+"})
     */
    public function form(EntityManagerInterface $em, Request $request, int $id)
    {
        if (!($this->isGranted("ROLE_PARTICIPANT"))) {

            $this->addFlash('danger', 'Vous devez être connecter');

            return $this->redirectToRoute('app_login');
        }


        $sortieRepository = $em->getRepository(Sortie::class);
        $sortie = $sortieRepository->find($id);

        $form = $this->createForm(CreationSortieType::class, $sortie);
        $form->handleRequest($request);
        $nom = $sortie->getNom();

        $valueInput = $request->get("sortie");
        if ($valueInput == 1) {
            $sortie->setNoEtat($em->getRepository(Etat::class)->findOneBy(array('libelle' => 'En Création')));
            dump($valueInput);
        } else {
            $sortie->setNoEtat($em->getRepository(Etat::class)->findOneBy(array('libelle' => 'Ouvert')));
            dump($valueInput);
        }

        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($sortie);
            $em->flush();
            $this->addFlash("succes", "Votre Sortie a bien été modifié");
            return $this->redirectToRoute("home");
        }

        return $this->render('sortie/creerModifierSortie.html.twig', [
            "form" => $form->createView(),
            "sortie" => $sortie,
            "modification"=>1
        ]);


    }


}

