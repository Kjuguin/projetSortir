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
     * @Route("/gestionProfil", name="gestionProfil")
     */
    public function form(EntityManagerInterface $em, Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $user = $this->getUser();

        $userForm = $this->createForm(GestionProfilType::class, $user);
        $userForm->handleRequest($request);

        if ($userForm->isSubmitted() && $userForm->isValid()) {
            if (empty($user)){
                $user->setPassword($this->getUser()->getPassword());
            } else {
                $password = $passwordEncoder->encodePassword($user, $user->getPassword());
                $user->setPassword($password);
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            $this->addFlash("succes", "User Modifié");
            return $this->redirectToRoute("utilisateur_gestionProfil");
        }

        return $this->render('utilisateurProfil/gestionProfil.html.twig', [
            "userForm" => $userForm->createView()]);

    }

    /**
     * @Route("/afficherProfil/{id}", name="afficherProfil", requirements={"id"="\d+"})
     */
    public function detail(int $id, EntityManagerInterface $em)
    {
        $profileRepository = $em->getRepository(User::class);
        $profile = $profileRepository->find($id);

        return $this->render(
            'utilisateurProfil/afficherProfil.html.twig',
            [
                'profile' => $profile
            ]
        );
    }
}
