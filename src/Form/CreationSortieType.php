<?php

namespace App\Form;

use App\Entity\Lieu;
use App\Entity\Sortie;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use function Sodium\add;

class CreationSortieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class,[
                'label'=>'Nom:'
            ])
            ->add('dateDebut', DateTimeType::class,[
                'label'=>'Date et heure de la sortie:',
                'widget' => 'single_text',
                "data" => new \DateTime(),
            ])
            ->add('dateCloture', DateTimeType::class,[
                'label'=>'Date limite inscription:',
                'widget' => 'single_text',
                "data" => new \DateTime(),
            ])
            ->add('nbInscriptionMax', IntegerType::class,[
                'label'=>'Nombre de places:',
                'attr'=>array('min'=>1),
            ])
            ->add('duree', IntegerType::class,[
                'label'=>'Durée (min):',
                'attr'=>array('min'=>1),

            ])
            ->add('descriptionInfos', TextareaType::class,[
                'label'=>'Description et infos:',
                'attr'=>['rows'=>'10','cols'=>'20']
            ])
            ->add('noLieu', EntityType::class,[
                'class'=>Lieu::class,
                'label'=>'Lieu:'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Sortie::class,
        ]);
    }
}
