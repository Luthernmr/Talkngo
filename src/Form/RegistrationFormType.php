<?php

namespace App\Form;

use App\Entity\User;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Rollerworks\Component\PasswordStrength\Validator\Constraints\PasswordStrength;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',TextType::class,[
                'label' => 'Nom',
                'required' => true,
                'constraints' => [
                    new Length([
                        'min' => 2,
                        'minMessage' => 'Votre nom doit comporter au minimun  {{ limit }} characters',
                        'max' => 30,
                        'maxMessage' => 'Votre nom doit comporter au minimun  {{ limit }} characters',
                    ]),
                ]
            ])
            ->add('first_name',TextType::class,[
                'label' => 'Prénom',
                'required' => true,
                'constraints' => [
                    new Length([
                        'min' => 2,
                        'minMessage' => 'Votre prenom doit comporter au minimun  {{ limit }} characters',
                        'max' => 30,
                        'maxMessage' => 'Votre prenom doit comporter au minimun  {{ limit }} characters',

                    ]),
                ]
            ])
            ->add('age',BirthdayType::class,[
                'label' => 'Date de naissance',
                'required' => true,
                'widget' => 'single_text',
                'html5' => 'false',
                'attr' => [
                    'class' => 'datepicker form-control',
                ],
                'placeholder' => [
                    'year' => 'Year', 'month' => 'Month', 'day' => 'Day',
                ]   
            ])
            ->add('location',TextType::class,[
                'label' => 'Ville',
                'constraints' => [
                    new Length([
                        'min' => 2,
                        'minMessage' => 'cette ville  n\'existe pas ',
                        'max' => 50,   

                    ]),
                ]
            ])
           
            ->add('description',TextareaType::class,[
                'required' => true,
                'label' => 'Description', 
                'constraints' => [
                    new Length([
                        'min' => 20 , 
                        'minMessage' => 'Votre description  doit comporter au minimun  {{ limit }} characters',
                        'max' => 1000,
                        'maxMessage' => 'Votre description est limité a {{ limit }} characters',

                    ]),
                ]    
            ])
            ->add('img', FileType::class, [

                'mapped' => false,
                'label' => 'Photo de profil',   
            ])
            ->add('email',EmailType::class,[
                'label' => 'Email',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrer un email ',
                    ]),
                ],
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'Vous devez accepter les conditions d\'utilisation .',
                    ]),
                ],
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'les deux mots de passe doivent correspondre .',
                'options' => ['attr' => ['class' =>'form-control']],
                'required' => true,
                'first_options'  => ['label' => 'mot de passe'],
                'second_options' => ['label' => 'confirmer mot de passe'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrer un mot de passe ',
                    ]),
                   
                    new PasswordStrength([
                        'minLength' => 8,
                        'tooShortMessage' => 'Le mot de passe doit contenir au moins 8 caractères',
                        'minStrength' => 4,
                        'message' => 'Le mot de passe doit contenir au moins une lettre minuscule, une lettre majuscule, un chiffre et un caractère spécial'
                    ])
                ],
            ]);
            
        
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
