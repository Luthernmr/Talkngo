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
     * @Route("/", name="home")
     */
    public function index()
    {
        $repo = $this->getDoctrine()->getRepository(Country::class);
        $countrys = $repo->findAll();
        return $this->render('/home/index.html.twig', [
            'controller_name' => 'HomeController',
          'countrys' =>  $countrys
          
        ]);
    }

    /**
     * @Route("/apropos", name="apropos")
     */

    public function aPropos()
    {
        $repo = $this->getDoctrine()->getRepository(Country::class);
        $countrys = $repo->findAll();
        return $this->render('/home/Apropos.html.twig', [
            
          'countrys' =>  $countrys
          
        ]);
    }

    /**
     * @Route("/contact", name="contact")
     */

    public function contact()
    {
        $repo = $this->getDoctrine()->getRepository(Country::class);
        $countrys = $repo->findAll();
        return $this->render('/home/contact.html.twig', [
            
          'countrys' =>  $countrys
          
        ]);
    }
  
  
}
