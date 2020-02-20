<?php

namespace App\Form;

use App\Entity\Lieu;
use App\Entity\Ville;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LieuType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nomLieu',TextType::class,[
                'attr' => ['id' => 'idNomLieu','name'=>'nameNomLieu', 'class'=> 'input-villieu'],
                'label'=>'Nom du lieu',
            ])

            ->add('rue', TextType::class, [
                'label'=>'Rue',
                'attr'=>['id'=> 'idRue', 'name' => 'nameRue', 'class'=>'input-villieu']
            ])

            ->add('latitude',IntegerType::class,[
                'label'=>'Latitude',
                'attr'=>['id' => 'idLatitude' , 'name' => 'nameLatitude', 'class'=>'input-villieu']
            ])

            ->add('longitude',IntegerType::class, [
                'label'=>'Longitude',
                'attr'=>['id' => 'idLongitude', 'name' => 'nameLongitude', 'class'=>'input-villieu']
            ])

            ->add('noVille',EntityType::class,[
                'class'=>Ville::class,
                'label'=>'Ville',
                'placeholder'=>' ',
                'attr'=>[
                    'id' => 'idVilleSave',
                    'class'=>'villeSave input-villieu',
                    'required'=>true
                ],
                'label_attr'=>['class'=>'labelVilleSave']
            ])

            ->add('Ville', VilleType::class,[
                'attr'=>[
                    'class'=>'noVilleLieu',
                    'require'=>'false',
                ]
            ])

            ->add('submit', SubmitType::class,[

                'attr'=>[
                    'class'=>'buttonSubmitVilleSave btn-base btn-red villieu-btn',
                ]])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Lieu::class,
        ]);
    }
}
