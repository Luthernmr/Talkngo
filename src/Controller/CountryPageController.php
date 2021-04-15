<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Country;
use App\Entity\Publication;
use App\Form\PublicationType;
use App\Controller\BaseController;
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
    public function index(Request $request, $id, EntityManagerInterface $entityManager){
        //récupération des données
        $repo = $this->getDoctrine()->getRepository(Country::class);
        $countrys = $repo->findAll();
        $user = $this->getUser();
        $country = $repo->find($id);
        $publications = $this->getDoctrine()->getManager()->getRepository(Publication::class)->findAll();
        
       //création du formulaire 
        $publication = new Publication();
        

        return $this->render('country_page/index.html.twig', [
            'country' => $country,
            'publications' => $publications,
            'countrys' => $countrys,
            'user' => $user,
            'publication' => $publication
        ]);
    }
  



}
   
