<?php

namespace App\Form;

use App\Entity\Publication;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;

class PublicationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('countryName',CountryType::class, [
            'label' => 'où allez vous'
                
        ])
            
            ->add('date')
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
