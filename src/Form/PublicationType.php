<?php

namespace App\Form;

use App\Entity\Publication;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class PublicationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('countryName', CountryType::class, [
                'label' => 'd\'où partez vous',])

            ->add('countryStart',CountryType::class, [
                    'label' => 'ou allez vous'])

            ->add('date' , BirthdayType::class, [
                'label' => 'Jour de départ',
            'widget' => 'single_text',
            'html5' => 'false',
            'attr' => [
                'class' => 'datepicker form-control'
            ],
            'placeholder' => [
                'year' => 'Year', 'month' => 'Month', 'day' => 'Day',
            ]
            
            
            
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
