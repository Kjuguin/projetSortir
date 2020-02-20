<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MdpOubliType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class,
                ['label'=>' ',
                    'attr'=>[
                        'class'=>'input-form',
                        'placeholder'=>'Email'
                    ]
                ]
            )
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Les mot de passe doivent correspondre',
                'first_options' => ['label' => ' ',
                    'attr'=>['class'=>'input-form',
                        'placeholder'=>'Mot de passe'],
                    'empty_data' => 'Pa$$w0rdPa$$w0rd'],
                'second_options' => ['label' => ' ',
                    'attr'=>['class'=>'input-form', 'placeholder'=>'Confirmation'],
                    'empty_data' => 'Pa$$w0rdPa$$w0rd'],
                'required' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
