<?php

namespace App\Controller;


use App\Entity\TestUn;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class TestController extends AbstractController
{
    /**
     * @Route("/test/recherche", name="test_recherche")
     */
    public function index(EntityManagerInterface $em, Request $request)
    {

        $encoder = new JsonEncoder();
        $defaultContext = [
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($object, $format, $context) {
                return $object->getNom();
            },
        ];
        $normalizer = new ObjectNormalizer(null, null, null, null, null, null, $defaultContext);

        $serializer = new Serializer([$normalizer], [$encoder]);


        $sortieRepository = $em->getRepository(TestUn::class);

        $param = [
            "site" => $request->get('site'),
            "nom" => $request->get('nom')
        ];


        $sorties = $sortieRepository->afficher($param);

        $serializer->serialize($sorties, 'json');

//        var_dump($serializer->serialize($org, 'json'));

        return $this->json(
            [
                "sorties" => $serializer, //problème ici
                "param" => $param
            ]);

    }

    /**
     * @Route("/test", name="test")
     */
    public function home(EntityManagerInterface $em, Request $request)
    {

        $sortieRepository = $em->getRepository(TestUn::class);

        $param = [
            "site" => $request->get('site'),
            "nom" => 'test'
        ];


        $sorties = $sortieRepository->afficher($param);

        return $this->render('home/test.html.twig',
            [
                'sorties' => $sorties,
            ]
        );

    }

}
