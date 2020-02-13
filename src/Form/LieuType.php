<?php

namespace App\Form;

use App\Entity\Lieu;
use App\Entity\Ville;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LieuType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nomLieu', TextType::class)
            ->add('rue', TextType::class)
            ->add('latitude', NumberType::class)
            ->add('longitude', NumberType::class)

            ->add('noVille', EntityType::class,
                [
                    'class'=> Ville::class,
                    'label'=>'nom ville:'
                ])

            ->add('NomVille', TextType::class)
            ->add('CodePostal', TextType::class)









//            ->add('noVille', CollectionType::class,[
//                'entry_type'=>new CreationVilleType(),
//                'allow_add'=>true
//            ])
            ;

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Lieu::class
        ]);
    }
}

