<?php

namespace App\Controller;

use App\Entity\Etat;
use App\Entity\Site;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Sortie;
use App\Form\CreationSortieType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;


class CreerSortieController extends AbstractController
{
    /**
     * @Route("/creerSortie", name="creer_sortie")
     */
    public function index(Request $request, EntityManagerInterface $em)
    {
        $sortie = new Sortie();
        $etat = new Etat();

        $form = $this->createForm(CreationSortieType::class, $sortie);
        $form->handleRequest($request);

            $currentUser = $this->getUser();
            $currentSite = $this->getUser()->getNoSite();
            $sortie = $sortie->setNoSite($em->getRepository(Site::class)->find($currentSite));

            $sortie= $sortie->setNoOrganisateur($currentUser);

        $valueInput = $request->get("buttonCreerUneSortie") ;

        if ($valueInput == 1 ){
            $sortie->setNoEtat($em->getRepository(Etat::class)->findOneBy(array('libelle' =>'En création')));
            dump($valueInput);
        } else {
            $sortie->setNoEtat($em->getRepository(Etat::class)->findOneBy(array('libelle' =>'Ouvert')));
            dump($valueInput);
        }

        if ($form->isSubmitted() && $form->isValid()) {

            $this->addFlash("success", "Sortie ajoutée");
            $em->persist($sortie);
            $em->flush();
            return $this->redirectToRoute("home");

        }

        return $this->render('creeSortie/index.html.twig',  [
            "form" => $form->createView()
        ]);
    }

}
