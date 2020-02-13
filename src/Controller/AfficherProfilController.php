<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/utilisateur", name="utilisateur_")
 */
class AfficherProfilController extends AbstractController
{

    /**
     * @Route("/profil/{id}", name="afficherProfil", requirements={"id"="\d+"})
     */
    public function detail(int $id, EntityManagerInterface $em)
    {
        $profileRepository = $em->getRepository(User::class);
        $profile = $profileRepository->find($id);

        return $this->render(
            'afficher_profil/afficherProfil.html.twig',
            [
                'profile' => $profile
            ]
        );
    }
}

