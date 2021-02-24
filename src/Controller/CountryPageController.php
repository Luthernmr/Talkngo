<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Country;
use App\Entity\Publication;
use Doctrine\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use App\DataFixtures\PublicationFixtures;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Form\PublicationType;

class CountryPageController extends AbstractController
{
    /**
     * @Route("/country/page", name="country_page")
     */
    public function index(Request $request, $id,EntityManagerInterface $entityManager){

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

        return $this->redirectToRoute('country_page/index.html.twig', [
            'countryPage' => $countryPage,
            'publications' => $publications,
            'formPublication' => $form->createView()
        ]);
    }


}
   
