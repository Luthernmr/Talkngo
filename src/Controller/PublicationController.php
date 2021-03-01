<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PublicationController extends AbstractController
{
  /**
     * @Route("/publication/{id}", name="publication_page")
     */
    public function affichePublication( $id){
        //récupération des données
        $repo = $this->getDoctrine()->getRepository(Country::class);
        $countrys = $repo->findAll();
        $user = $this->getUser();
        $publication = $this->getDoctrine()->getManager()->getRepository(Publication::class)->findAll($id);
        
  
    

        return $this->render('publication/index.html.twig', [
            'publication' => $publication,
            'countrys' => $countrys,
            'user' => $user,
        ]);
    }
    
}
