<?php

namespace App\Form;

use App\Entity\Lieu;
use App\Entity\Sortie;
use DateTime;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CreationSortieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Nom'
            ])
            ->add('dateDebut', DateTimeType::class, [
                'label' => 'Date et heure de la sortie',
                'widget' => 'single_text',
                "data" => new DateTime(),
            ])
            ->add('dateCloture', DateTimeType::class, [
                'label' => 'Date limite d\'inscription',
                'widget' => 'single_text',
                "data" => new DateTime(),
            ])
            ->add('nbInscriptionMax', IntegerType::class, [
                'label' => 'Nombre de places',
                'attr' => array('min' => 1),
            ])
            ->add('duree', IntegerType::class, [
                'label' => 'Durée (minutes)',
                'attr' => array('min' => 1),

            ])
            ->add('descriptionInfos', TextareaType::class, [
                'label' => 'Description et infos',
                'attr' => ['class' => 'dtl-descp2']
            ])
            ->add('noLieu', EntityType::class, [
                'class' => Lieu::class,
                'label' => 'Lieu',
                'placeholder'=>'Veuillez choisir un lieu',
            ]);

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Sortie::class,
        ]);
    }
}
