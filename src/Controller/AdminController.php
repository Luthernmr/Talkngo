<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
<<<<<<< HEAD
    {  
=======
    { $repo = $this->getDoctrine()->getRepository(Country::class);
        $countrys = $repo->findAll();
>>>>>>> cc601a5077ba7742a4f6fae72053eedf898f9fb8

        return $this->render('admin/admin.html.twig', [
            'controller_name' => 'AdminController',
    
        ]);
    }
}
