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

        $formLieu = $this->createForm(LieuType::class, $lieu);

        $formLieu->handleRequest($request);

        if ($formLieu->isSubmitted() && $formLieu->isValid()) {

            $nomVilleRecup= $lieu->getVille()->getNomVille();//ok
            $codePostalRecup= $lieu->getVille()->getCodePostal();


            $villeRepository = $em->getRepository(Ville::class);
            $villeNomBDD = $villeRepository->findBy(
                ['nomVille' => $nomVilleRecup]
            );

            $villeCPBDD = $villeRepository->findBy([
                'codePostal' => $codePostalRecup
            ]);

            if ($villeNomBDD && $villeCPBDD ) {


                $this->addFlash("default", 'La ville ou le code postal existe déjà');

                return $this->redirectToRoute("ajoutLieuVille");

            }else {

                if ($lieu->getNoVille()) {
                    $ville = $em->getRepository(Ville::class)->find($lieu->getNoVille());
                    $lieu->setVille($ville);
                }
                $em->persist($lieu);
                $em->flush();

                if (!$lieu->getNoVille()) {

                    $ville = $em->getRepository(Ville::class)->find($lieu->getVille());
                    $lieu->setNoVille($ville);
                    $em->flush();
                }

                $this->addFlash("success", "lieu ajouté");
                return $this->redirectToRoute("ajoutLieuVille");
            }
        }

        return $this->render('creation_lieu_ville/index.html.twig', [
            "formLieu" => $formLieu->createView(),
        ]);

    }

}
