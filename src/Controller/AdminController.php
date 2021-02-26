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
    { $repo = $this->getDoctrine()->getRepository(Country::class);
        $countrys = $repo->findAll();

        return $this->render('admin/admin.html.twig', [
            'controller_name' => 'AdminController',
            'countrys' => $countrys
    
        ]);
    }
}
