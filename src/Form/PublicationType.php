<?php

namespace App\Form;

use App\Entity\Country;
use App\Entity\Publication;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\DateIntervalType;

class PublicationType extends AbstractType
{
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('countryName',ChoiceType::class, [
                'class' => Country::class,
                'label' => 'Destination',
                'choice_value'=> function(?Country $country){
                    return $country ? $country->getCountryName() : '';}
            ])
            ->add('date', BirthdayType::class,[
                'required' => true,
                'label' => 'Date de départ',
                'placeholder' => [
                    'year' => 'Year', 'month' => 'Month', 'day' => 'Day',
                ]
                 
            ])
          
            ->add('duration', DateIntervalType::class, [
                'widget'      => 'integer', // render a text field for each part
                // 'input'    => 'string',  // if you want the field to return a ISO 8601 string back to you
            
                // customize which text boxes are shown
                'with_years'  => false,
                'with_months' => true,
                'with_days'   => true,
            ]);
            


    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Publication::class,
        ]);
    }
}
