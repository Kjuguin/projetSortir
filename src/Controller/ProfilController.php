<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\GestionProfilType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/utilisateur", name="utilisateur_")
 */
class ProfilController extends AbstractController
{
    /**
     * @Route("/gestionProfil/{id}", name="gestionProfil", requirements={"id"="\d+"})
     */
    public function form(EntityManagerInterface $em, Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $user2 = new User();
        $user2->setPassword($this->getUser()->getPassword());
        $user = $this->getUser();

        $userForm = $this->createForm(GestionProfilType::class, $user);

        $userForm->handleRequest($request);

        if ($userForm->isSubmitted() && $userForm->isValid()) {
            if ($user->getPassword() == 'Pa$$w0rdPa$$w0rd'){
                $user->setPassword($user2->getPassword());
            } else {
                $password = $passwordEncoder->encodePassword($user, $user->getPassword());
                $user->setPassword($password);
            }

            $em->persist($user);
            $em->flush();
            $this->addFlash("succes", "Votre profil a bien été modifié");
            return $this->redirectToRoute("utilisateur_afficherProfil", ['id' => $user->getId()]);
        }

        return $this->render('utilisateurProfil/gestionProfil.html.twig', [
            "userForm" => $userForm->createView()
        ]);


    }

    /**
     * @Route("/afficherProfil/{id}", name="afficherProfil")
     */
    public function afficherProfil($id, EntityManagerInterface $em)
    {

        $profileRepository = $em->getRepository(User::class);
        $profil = $profileRepository->find($id);
        if ($profil == null) {
            throw $this->createNotFoundException("Utilisateur inconnu");
        }
        return $this->render(
            'utilisateurProfil/afficherProfil.html.twig',
            [
                'profil' => $profil
            ]
        );
    }
}
