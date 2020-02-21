<?php

namespace App\Form;

use App\Entity\Lieu;
use App\Entity\Ville;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
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
                'attr' => ['id' => 'idNomLieu','name'=>'nameNomLieu'],
                'label'=>'Nom Lieu:',
            ])

            ->add('rue', TextType::class, [
                'label'=>'Rue:',
                'attr' => ['id'=> 'idRue', 'name' => 'nameRue'],
            ])

            ->add('latitude',NumberType::class,[
                'label'=>'Latitude:',
                'attr' => ['id' => 'idLatitude' , 'name' => 'nameLatitude'],
            ])

            ->add('longitude',NumberType::class, [
                'label'=>'Longitude:',
                'attr' => ['id' => 'idLongitude', 'name' => 'nameLongitude']
            ])

            ->add('noVille',EntityType::class,[
                'class'=>Ville::class,
                'label'=>'Nom Ville:',
                'placeholder'=>' ',
                'attr'=>[
                    'id' => 'idVilleSave',
                    'class'=>'villeSave',
                    'required'=>true
                ],
                'label_attr'=>['class'=>'labelVilleSave']
            ])

            ->add('Ville', VilleType::class,[
                'attr'=>[
                    'id' => 'idVille',
                    'class'=>'noVilleLieu',
                    'require'=>'false',
                ],
                'label' => 'Ajout Ville',
                'label_attr'=>['class'=>'labelVille']
            ])

            ->add('submit', SubmitType::class,[
                'attr'=>[
                    'class'=>'buttonSubmitVilleSave',
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
