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
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;

use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class UpdateAdminFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',TextType::class,[
                'label' => 'nom',
                'required' => true,
            ])
            ->add('first_name',TextType::class,[
                'label' => 'prenom',
                'required' => true,
            ])

            ->add('age',BirthdayType::class,[
                'label' => 'Date de naissance',
                'required' => true,
                'widget' => 'single_text',
                'html5' => 'false',
                'attr' => [
                    'class' => 'datepicker form-control'
                ],
                'placeholder' => [
                    'year' => 'Year', 'month' => 'Month', 'day' => 'Day',
                ]
                
                
                
            ])
            ->add('location',TextType::class,[
                'label' => 'ville',
            ])
           
            ->add('description',TextareaType::class,[
                'required' => true,
                'label' => 'description',
                 
            ])
            ->add('img', FileType::class, [

                'required' =>false,

                'mapped' => false,
                'label' => 'Photo de profil',
                
            ])

            ->add('email',EmailType::class,[
                'label' => 'email',
            ])
            
            ->add('roles',ChoiceType::class,[
                'choices' => [
                    'utilisateur' => 'ROLE_USER',
                    'moderateur' => 'ROLE_MODO',
                    'administrateur' => 'ROLE_ADMIN',
                    
                ],
                'expanded' => true ,
                'multiple' => true ,
                'label' => 'role'
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
