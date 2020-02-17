<?php

namespace App\Controller;


use App\Entity\Sortie;
use App\Entity\TestUn;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\AnnotationLoader;
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

//        $encoder = new JsonEncoder();
//        $defaultContext = [
//            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($object, $format, $context) {
//                    return $object->getNom();
//            },
//        ];
//        $normalizer = new ObjectNormalizer(null, null, null, null, null, null, $defaultContext);
//
//        $serializer = new Serializer([$normalizer], [$encoder]);
        $classMetadataFactory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));

        $normalizer = new ObjectNormalizer($classMetadataFactory);
        $serializer = new Serializer([$normalizer]);



        $sortieRepository = $em->getRepository(TestUn::class);

        $param = [
            "site" => $request->get('site'),
            "nom" => $request->get('nom')
        ];


        $sorties = $sortieRepository->afficher($param);

        $data = $serializer->normalize($sorties, null, ['groups' => 'group1']);
//        $data = $serializer->normalize($sorties, 'json', ['groups' => 'group1']);

//        var_dump($serializer->serialize($org, 'json'));

//        return new JsonResponse($data, Response::HTTP_OK, [], true);
return $this->json(['sorties'=>$data]);
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
