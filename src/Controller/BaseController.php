<?php

namespace App\Controller;

use App\Entity\Country;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BaseController extends AbstractController
{
    /**
     * @Route("/base", name="base")
     */
    public function ajout():Response
    {
        $repo = $this->getDoctrine()->getRepository(Country::class);
        $countrys = $repo->findAll();
        $user = $this->getUser();
    
        return $this->render('base.html.twig', [
            'controller_name' => 'BaseController',
            'user' => $user,
            'countrys'=> $countrys
            ]);
    }
}
