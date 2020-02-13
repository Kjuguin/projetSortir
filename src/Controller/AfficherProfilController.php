<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AfficherProfilController extends AbstractController
{
    /**
     * @Route("/profil/{id}", name="afficherProfil", requirements={"id"="\d+"})
     * @param int $id
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function detail(int $id, EntityManagerInterface $em)
    {
        $profileRepository = $em->getRepository(User::class);
        $profile = $profileRepository->find($id);
        return $this->render('afficher_profil/afficherProfil.html.twig', ['profile' => $profile]
        );
    }
}

