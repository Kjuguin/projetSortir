<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\AvatarType;
use App\Form\GestionProfilType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Service\FileUploader;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/utilisateur", name="utilisateur_")
 */
class ProfilController extends AbstractController
{
    /**
     * @Route("/gestionProfil/{id}", name="gestionProfil")
     */
    public function form(EntityManagerInterface $em, Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        if (!($this->isGranted("ROLE_PARTICIPANT"))) {

            $this->addFlash('danger', 'Vous devez être connecter');

            return $this->redirectToRoute('app_login');
        }

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
    public function afficherProfil(int $id, EntityManagerInterface $em)
    {

        if (!($this->isGranted("ROLE_PARTICIPANT"))) {

            $this->addFlash('danger', 'Vous devez être connecter');

            return $this->redirectToRoute('app_login');
        }

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
    /**
     * @Route("/modifierPhoto", name="modifierPhoto")
     */
    public function modifierPhotoDeProfil(EntityManagerInterface $em, Request $request, FileUploader $fileUploader)
    {
        $user = $this->getUser();
        $avatarForm = $this->createForm(AvatarType::class, $user);
        $avatarForm->handleRequest($request);

        dump($user);
        if ($avatarForm->isSubmitted() && $avatarForm->isValid()) {

            // on place l'URL du fichier upload dans une variable $file
            /** @var UploadedFile $file */
            $file = $avatarForm->get('urlPhoto')->getData();
            // On renomme le fichier dans un langage utilisable et
            // on upload le fichier dans public/profile_directory,
            // grace au App/Service/FileUploader; puis on l'attribut à une variable.
            // (Sans ça l'URL du fichier sera écrit en BDD dans un répértoire Wamp non accessible)
            $fileName = $fileUploader->upload($file);
            // On remplis l'user avec la variable
            $user->setUrlPhoto($fileName);
dump($fileName);
            $em->persist($user);
            $em->flush();
            $this->addFlash("success", "Photo modifiée avec succès !");

            return $this->redirectToRoute('utilisateur_gestionProfil', [
                'id' => $this->getUser()->getId()
             ]);
        }

        return $this->render('utilisateurProfil/modifierPhotos.html.twig', [
            'avatarForm' => $avatarForm->createView()
        ]);
    }


}
