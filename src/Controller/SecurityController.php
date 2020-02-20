<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/registration", name="registration")
     */
    public function registration(UserPasswordEncoderInterface $passwordEncoder, EntityManagerInterface $em, Request $request)
    {

        if (!($this->isGranted("ROLE_ADMIN"))) {

            $this->addFlash('danger', 'Vous devez être administrateur');

            return $this->redirectToRoute('home');
        }


        $user = new User();
        $user->setPseudo("test");

        $form = $this->createForm(RegistrationType::class, $user);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            // Etape de plus : hasher le mot de pass

            $hash = $passwordEncoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hash);
            $user->setPseudo($user->getEmail());

            $user->setRoles(['ROLE_PARTICIPANT']);

            $user->setNom(ucfirst(strtolower($user->getNom())));
            $user->setPrenom(ucfirst(strtolower($user->getPrenom())));
            $user->setUrlPhoto('profile_directory/avatar-dft.png');


            $em->persist($user);
            $em->flush();

            $this->addFlash("success", "Inscription réussie !");

            return $this->redirectToRoute('registration');
        }

        return $this->render('security/registration.html.twig', [
            "form" => $form->createView()
        ]);
    }

    /**
     * @Route("/login", name="app_login")
     */


    public function login(AuthenticationUtils $authenticationUtils): Response
    {

        if (($this->isGranted("ROLE_USER"))) {

            $this->addFlash('danger', 'Vous êtes déjà connecté');

            return $this->redirectToRoute('home');
        }

        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     * @throws \Exception
     */
    public function logout()
    {
        throw new \Exception('This method can be blank - it will be intercepted by the logout key on your firewall');
    }
}
