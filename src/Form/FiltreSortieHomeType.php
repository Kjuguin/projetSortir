<?php

namespace App\Form;

use App\Entity\Sorties;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FiltreSortieHomeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
//            ->add('nom')
            ->add('date_debut')
//            ->add('duree')
            ->add('date_cloture')
//            ->add('nb_inscription_max')
//            ->add('description_infos')
            ->add('etat_sortie')
//            ->add('url_photo')
            ->add('organisateur')
            ->add('lieux_no_lieu')
//            ->add('etats_no_etat')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Sorties::class,
        ]);
    }
}
