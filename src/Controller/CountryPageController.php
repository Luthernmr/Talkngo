<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Country;
use App\Entity\Publication;
use App\Form\PublicationType;
use Doctrine\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use App\DataFixtures\PublicationFixtures;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CountryPageController extends AbstractController
{
    /**
     * @Route("/country/page/{id}", name="country_page")
     */
    public function index(Request $request, $id,EntityManagerInterface $entityManager){
        //récupération des données
        $repo = $this->getDoctrine()->getRepository(Country::class);
        $countryPage = $repo->find($id);
        $publications = $this->getDoctrine()->getManager()->getRepository(Publication::class)->findAll();
        $repo = $this->getDoctrine()->getRepository(Country::class);
        $countrys = $repo->findAll();
        
       //création du formulaire 
        $publication=new Publication();
        $form =$this->createForm(PublicationType::class,$publication);

        
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()){
            //récuperer les tokens de l'utilisateur connecté
            

            $user = $this->get('security.token_storage')->getToken()->getUser();
            $publication->setUser($user);
            
            $manager= $this->getDoctrine()->getManager();
            $manager->persist($publication);
            $manager->flush();
        }

        return $this->render('country_page/index.html.twig', [
            'countryPage' => $countryPage,
            'publications' => $publications,
            'countrys' => $countrys,
            'formPublication' => $form->createView()
        ]);
    }


}
   
