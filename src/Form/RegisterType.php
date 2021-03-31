<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', TextType::class,[
                'label'=> 'votre prénom',
                'constraints'=> new Length(2,30),
                'attr' => [
                    'placeholder' => 'Saisir votre prénom'
                ]

            ]) //ajout input prenom
            ->add('lastName', TextType::class,[
                'label'=> 'Votre nom',
                'constraints'=> new Length(2,30),
                'attr'=> [
                    'placeholder'=> 'Saisir votre nom'
                ]
            ]) //ajout input nom
            ->add('email', EmailType::class,[
                'label'=> 'Courriel',
                'constraints'=> new Length(2,60),
                'attr'=> [
                    'placeholder'=> 'Saisir votre adresse mail'
                ]
            ]) //ajout input email
            ->add('password', RepeatedType::class,[
                'type'=> PasswordType::class,
                'invalid_message'=>'Mot de passe incorrecte, need t be the same',
                'label'=> 'Mot de passe',
                'required'=> true,
                'first_options'=> [
                    'label'=>'Mot de passe',
                    'attr' => [
                        'placeholder'=> 'Saisir un mot de passe'
                    ]
                ],
                'second_options' => [
                    'label'=>'Confirmez mot de passe',
                    'attr'=> [
                        'placeholder'=>'Confirmer votre mot de passe'
                    ]
                ]
            ]) //ajout input mot de passe
            ->add('submit', SubmitType::class, [
                'label'=> "S'incrire"
            ]) //ajout btn submit

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
