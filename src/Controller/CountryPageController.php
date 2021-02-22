<?php

namespace App\Controller;

use App\Entity\Country;
use App\Entity\Publication;
use App\DataFixtures\PublicationFixtures;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CountryPageController extends AbstractController
{
    /**
     * @Route("/country/page-{id}", name="country_page")
     */
    public function index($id){

        $repo = $this->getDoctrine()->getRepository(Country::class);
        $countryPage = $repo->find($id);
        $publications = $this->getDoctrine()->getManager()->getRepository(Publication::class)->findAll();
        $user = $this->getDoctrine()->getManager()->getRepository(User::class)->findAll();

        
    

        return $this->render('country_page/index.html.twig', [
            'countryPage' => $countryPage,
            'publications' => $publications
        ]);
    }
}
   
