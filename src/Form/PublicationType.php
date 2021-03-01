<?php

namespace App\Form;

use App\Entity\Publication;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
<<<<<<< HEAD
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
=======
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
>>>>>>> 3fd48eb15b9132ff8cfe52a76d4d0deec879e326

class PublicationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
<<<<<<< HEAD
            ->add('countryName', CountryType::class, [
                'label' => 'd\'où partez vous',])

            ->add('countryStart',CountryType::class, [
                    'label' => 'ou allez vous'])

            ->add('date' , BirthdayType::class, [
                'label' => 'Jour de départ',
=======
        ->add('countryName',CountryType::class, [
            'label' => 'où allez vous'
                
        ])
            
        ->add('date',BirthdayType::class,[
            'label' => 'modifier les dates',
            'required' => true,
>>>>>>> 3fd48eb15b9132ff8cfe52a76d4d0deec879e326
            'widget' => 'single_text',
            'html5' => 'false',
            'attr' => [
                'class' => 'datepicker form-control'
            ],
            'placeholder' => [
                'year' => 'Year', 'month' => 'Month', 'day' => 'Day',
            ]
            
            
            
        ])
            ->add('duration')
            ->add('img', FileType::class, [

                'mapped' => false,
                'label' => 'Ajouter une image pour ce pays',
                
            ])
            ->add('countryStart', CountryType::class, [
                'label' => 'd\'où partez vous',
                
                
            ])
           
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Publication::class,
        ]);
    }
}
