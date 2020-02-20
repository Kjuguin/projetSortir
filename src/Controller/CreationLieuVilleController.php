<?php

namespace App\Controller;

use App\Entity\Lieu;
use App\Entity\Site;
use App\Entity\Sortie;
use App\Entity\Ville;
use App\Form\LieuType;
use App\Form\VilleType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\UriSigner;
use Symfony\Component\Routing\Annotation\Route;

class CreationLieuVilleController extends AbstractController
{
    /**
     * @Route("/ajoutLieuVille/{token}", name="ajoutLieuVille")
     */
    public function form($token = null, EntityManagerInterface $em, Request $request)
    {
        dump($token);
        $tok = base64_decode($token);
//        $tok = $tok.",".$id;
        dump($token);
        $token=base64_encode($tok);


        $lieu = new Lieu();

        $formLieu = $this->createForm(LieuType::class, $lieu);

        $formLieu->handleRequest($request);

        if ($formLieu->isSubmitted() && $formLieu->isValid()) {


            $nomVilleRecup= $lieu->getVille()->getNomVille();//ok
            $codePostalRecup= $lieu->getVille()->getCodePostal();
            $lieuNomRecup = $lieu->getNomLieu();


            $lieuRepository = $em->getRepository(Lieu::class);
            $lieuNomBDD= $lieuRepository->findBy(
                ['nomLieu' => $lieuNomRecup]
            );

            $villeRepository = $em->getRepository(Ville::class);
            $villeNomBDD = $villeRepository->findBy(
                ['nomVille' => $nomVilleRecup]
            );

            $villeCPBDD = $villeRepository->findBy([
                'codePostal' => $codePostalRecup
            ]);



                $this->addFlash("default", 'La ville, le code postal existe déjà');

                return $this->redirectToRoute("ajoutLieuVille");


            }elseif ($lieuNomBDD) {

                $this->addFlash("default", 'Le nom du lieu existe déjà');

                return $this->redirectToRoute("ajoutLieuVille");

            } else {

                if ($lieu->getNoVille()) {
                    $ville = $em->getRepository(Ville::class)->find($lieu->getNoVille());
                    $lieu->setVille($ville);
                    $em->persist($lieu);
                    $em->flush();

                }

                if (!$lieu->getNoVille()) {

                    $ville = $em->getRepository(Ville::class)->find($lieu->getVille());
                    $lieu->setNoVille($ville);
                    $em->flush();


                }


                $id = $lieu->getId();

                dump($id);

                $this->addFlash("success", "lieu ajouté");

                dump($token);

                if ($token){
                    $tok = base64_decode($token);
                    $tok = $tok.",".$id;
                    dump($tok);
                    $token=base64_encode($tok);
                }

                 return $this->redirectToRoute("creer_sortie", [

                    'token' => $token,]);
            }
        }

        return $this->render('creation_lieu_ville/index.html.twig', [
            "formLieu" => $formLieu->createView(),
        ]);

    }



}
