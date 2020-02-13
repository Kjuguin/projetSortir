<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\GestionProfilType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ProfilController extends AbstractController
{
    /**
     * @Route("/gestionProfil", name="gestionProfil")
     * @param EntityManagerInterface $em
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function form(EntityManagerInterface $em, Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
            $user = $this->getUser();
            $userForm = $this->createForm(GestionProfilType::class, $user);
            $userForm->handleRequest($request);
            if ($userForm->isSubmitted()) {
                $this->addFlash("succes", "User Modifié");
                $password = $passwordEncoder->encodePassword($user, $user->getPassword());
                $user->setPassword($password);
                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();

                return $this->redirectToRoute("gestionProfil");
            }
//bla
            return $this->render('Profil/gestionProfil.html.twig', [
                "userForm" => $userForm->createView()]);

        }
}