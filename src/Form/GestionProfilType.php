<?php

namespace App\Form;

use App\Entity\Site;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GestionProfilType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('pseudo', TextType::class, ['label'=>'Pseudo : '])
            ->add('email', EmailType::class, ['label'=>'Email : '])
            ->add('prenom', TextType::class, ['label'=>'Prénom : '])
            ->add('nom', TextType::class, ['label'=>'Nom : '])
            ->add('telephone', TextType::class, ['label'=>'Téléphone : '])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Les mot de passe doivent correspondre',
                'first_options' => ['label' => 'Mot de passe : ',
                    'empty_data' => 'Pa$$w0rdPa$$w0rd'],
                'second_options' => ['label' => 'Vérification mot de passe : ',
                    'empty_data' => 'Pa$$w0rdPa$$w0rd'],
                'required' => false
            ])

            ->add('noSite', EntityType::class, [
                'class' => Site::class,
                'label' => 'Site : '
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
