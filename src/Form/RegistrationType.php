<?php

namespace App\Form;

use App\Entity\Site;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email',EmailType::class,
                ['label'=>'Email', 'attr'=>['class'=>'input-register']]
            )

            ->add('password', PasswordType::class,
                ['label'=>'Mot de passe', 'attr'=>['class'=>'input-register']]
            )

            ->add('nom', TextType::class,
                ['label'=>'Nom', 'attr'=>['class'=>'input-register']]
            )

            ->add('prenom', TextType::class,
                ['label'=>'Prénom', 'attr'=>['class'=>'input-register']]
            )

            ->add('noSite', EntityType::class, [
                'class' => Site::class,
                'label' => 'Site', 'attr'=>['class'=>'input-register']
            ])

            ->add('Register', SubmitType::class, ['label' => 'Enregistrer','attr'=>['class'=>'btn-register btn-base btn-red']])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
