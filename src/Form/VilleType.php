<?php

namespace App\Form;

use App\Entity\Lieu;
use App\Entity\Ville;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VilleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nomVille', TextType::class,[
                'label'=>'Nom ville:',
                'required'=>false,
                'attr'=>[
                    'class'=>'nomVilleMasque'
                ],
                'label_attr'=>['class'=>'labelNomVilleMasque']
            ])
            ->add('codePostal', TextType::class,[
                'label'=>'Code postal:',
                'required'=>false,
                'attr'=>[
                    'class'=>'codePostalMasque'
                ],
                'label_attr'=>['class'=>'labelCodePostalMasque']
            ])
            ->add('Submit', SubmitType::class,[
                'attr'=>[
                    'class'=>'buttonSubmitMasque'
                ]])
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Ville::class,
        ]);
    }
}
