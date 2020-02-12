<?php
//
//namespace App\Controller;
//
//use App\Entity\Lieu;
//use App\Entity\Ville;
//use App\Form\LieuType;
//use Doctrine\ORM\EntityManagerInterface;
//use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
//use Symfony\Component\HttpFoundation\Request;
//use Symfony\Component\Routing\Annotation\Route;
//
//class CreationLieuVilleController extends AbstractController
//{
//    /**
//     * @Route("/ajoutLieuVille", name="ajoutLieuVille")
//     */
//    public function form(EntityManagerInterface $em, Request $request)
//    {
//        $lieu = new Lieu();
//        $ville = new Ville();
//
//
//        $form = $this->createForm(LieuType::class, $lieu);
//bla
//        $form->handleRequest($request);
//        if ($form->isSubmitted() && $form->isValid()) {
//            $this->addFlash("succes", "lieu ajouté");
//
//            $em->persist($lieu);
//            $em->persist($ville);
//            $em->flush();
//
//            return $this->redirectToRoute("creation_sortie");
//        }
//
//        return $this->render('creation_lieu_ville/creationLieuVille.html.twig', [
//            "form" => $form->createView()]);
//
//    }
//}
