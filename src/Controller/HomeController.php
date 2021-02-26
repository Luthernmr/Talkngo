<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Country;
use App\Entity\Publication;
use App\Form\PublicationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     */
    public function index()
    {
<<<<<<< HEAD
        
        return $this->render('home/index.html.twig', [
=======
        $repo = $this->getDoctrine()->getRepository(Country::class);
        $countryPage = $repo->findAll();
        $repo = $this->getDoctrine()->getRepository(Country::class);
        $countrys = $repo->findAll();
        return $this->render('index.html.twig', [
>>>>>>> cc601a5077ba7742a4f6fae72053eedf898f9fb8
            'controller_name' => 'HomeController',
          
        ]);
    }

  
}
