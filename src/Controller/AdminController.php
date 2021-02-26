<?php

namespace App\Controller;

use App\Entity\Country;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {  

        return $this->render('admin/admin.html.twig', [
            'controller_name' => 'AdminController',
    
        ]);
    }
}
