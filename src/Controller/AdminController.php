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
    public function index(BaseController $baseController): Response
    {  
        $countrys = $baseController->ajout();

        return $this->render('admin/admin.html.twig', [
            'controller_name' => 'AdminController',
            'countrys' => $countrys
    
        ]);
    }
}
