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
        $countryPage = $repo->findAll();
        $repo = $this->getDoctrine()->getRepository(Country::class);
        $countrys = $repo->findAll();
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'countrys' => $countrys,
            'countryPage' => $countryPage
        ]);
    }

    /**
     * @Route("/country/page/{id}", name="country_page")
     */
    public function show(Request $request, $id,EntityManagerInterface $entityManager){

        $repo = $this->getDoctrine()->getRepository(Country::class);
        $countryPage = $repo->find($id);
        $publications = $this->getDoctrine()->getManager()->getRepository(Publication::class)->findAll();
        $publication = $this->getDoctrine()->getManager()->getRepository(Publication::class)->findAll();
        $user = $this->getDoctrine()->getManager()->getRepository(User::class)->findAll();
        
        
        $publication=new Publication();
        $form =$this->createForm(PublicationType::class,$publication);

        
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()){

            $manager= $this->getDoctrine()->getManager();
            $manager->persist($publication);
            $manager->flush();
        }

        return $this->render('country_page/index.html.twig', [
            'countryPage' => $countryPage,
            'publications' => $publications,
            'formPublication' => $form->createView()
        ]);
    }
}
