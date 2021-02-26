<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Country;
use App\Entity\Publication;
use App\Form\PublicationType;
use Doctrine\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use App\DataFixtures\PublicationFixtures;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\DateIntervalType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CountryPageController extends AbstractController
{
    /**
     * @Route("/country/page/{id}", name="country_page")
     */
    public function index(Request $request, $id,EntityManagerInterface $entityManager){
        //récupération des données
        $repo = $this->getDoctrine()->getRepository(Country::class);
        $countryPage = $repo->find($id);
        $publications = $this->getDoctrine()->getManager()->getRepository(Publication::class)->findAll();
        $countrys = $repo->findAll();
        
        
       //création du formulaire 
        $publication=new Publication();
        $form =$this->createFormBuilder($publication)
                
                ->add('countryName',TextType::class, [
                    'label' => 'Destination',
                    
                        
                ])
                        
                ->add('date', BirthdayType::class,[
                    'required' => true,
                    'label' => 'Date de départ',
                    'placeholder' => [
                        'year' => 'Year', 'month' => 'Month', 'day' => 'Day',
                    ]
                     
                ])
                ->add('duration', DateIntervalType::class, [
                    'input'      => 'string', // render a text field for each part
                    // 'input'    => 'string',  // if you want the field to return a ISO 8601 string back to you
                
                    // customize which text boxes are shown
                    'with_years'  => false,
                    'with_months' => true,
                    'with_days'   => true,
                ])
                ->getForm();
                
    
        
        
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()){
            //récuperer les tokens de l'utilisateur connecté
            $user = $this->get('security.token_storage')->getToken()->getUser();
            $publication->setUser($user);
            
            $manager= $this->getDoctrine()->getManager();
            $manager->persist($publication);
            $manager->flush();
        }

        return $this->render('country_page/index.html.twig', [
            'countryPage' => $countryPage,
            'publications' => $publications,
            'countrys' => $countrys,
            'formPublication' => $form->createView()
        ]);
    }




}
   
