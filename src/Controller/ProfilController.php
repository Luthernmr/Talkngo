<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Country;
use App\Entity\Publication;
use App\Form\PublicationType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\PublicationRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\ChoiceList\ChoiceList;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\DateIntervalType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProfilController extends AbstractController
{
    /**
     * @Route("/profil", name="profil")
     */
    public function index(Request $request,EntityManagerInterface $entityManager,UserRepository $userRepository): Response
    {
       
        $repo = $this->getDoctrine()->getRepository(Country::class);
        $countrys = $repo->findAll();
        $publications = $this->getDoctrine()->getManager()->getRepository(Publication::class)->findAll();
        $user = $this->getUser();
        
        
        
            $datetime = date_format($user->getAge(), 'Y-m-d');
            $timestamp = strtotime($datetime);
            $age = abs((time() - $timestamp) / (3600 * 24 * 365));
            $age = floor($age);
        
        $publication = new Publication();
        $form =$this->createForm(PublicationType::class, $publication);
                
    
        
        
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()){
            //récuperer les tokens de l'utilisateur connecté
            $user = $this->get('security.token_storage')->getToken()->getUser();
            $publication->setUser($user);
            
            $manager= $this->getDoctrine()->getManager();
            $manager->persist($publication);
            $manager->flush();
            

            $this->addFlash('message', 'Votre annoce à bien été publié');
            return $this->redirectToRoute('profil');
        } 




    
// formulaire modif

        $formProfil = $this->createForm(UpdateProfilFormType::class, $user);
        $formProfil->handleRequest($request);
        if ($formProfil->isSubmitted() && $formProfil->isValid()) {
            $infoImg = $formProfil['img']->getData(); // récupère les infos de l'image 
            $extensionImg = $infoImg->guessExtension(); // récupère le format de l'image 
            $nomImg = time() . '.' . $extensionImg; // compose un nom d'image unique
            $infoImg->move($this->getParameter('dossier_photos_user'), $nomImg); // déplace l'image
            $user->setImg($nomImg);
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($user);
            $manager->flush();

            $this->addFlash(
                'success',
                'Information  a bien été modifiée'
            );

            return $this->redirectToRoute('profil');
        }
      
       
        return $this->render('profil/index.html.twig', [
            'user' => $user,
            'publications' => $publications,
            'countrys' => $countrys,
            'formPublication' => $form->createView(),
            'updateProfilForm' => $formProfil->createView(),
            'user_age' => $age,
        ]);
        
        }
    
    
    /**
     * @Route("/profil/update-{id}", name="publication_update")
     */
    public function updatePublication(PublicationRepository $publicationRepository, $id, Request $request): Response
    { 
        
        $publication = $publicationRepository->find($id);
        $form = $this->createForm(PublicationType::class, $publication);
        $form->handleRequest($request);
        $repo = $this->getDoctrine()->getRepository(Publication::class);
        $countrys = $repo->findAll();

        if ($form->isSubmitted() && $form->isValid()) {
            $oldNomImg = $publication->getImg(); //ancien image
            $oldCheminImg = $this->getParameter('dossier_photos_pays') . '/' . $oldNomImg;

            

            $infoImg = $form['img']->getData();
            $extensionImg = $infoImg->guessExtension();

            $nomImg = time() . '.' . $extensionImg;
            $infoImg->move($this->getParameter('dossier_photos_pays'), $nomImg);
            $publication->setImg($nomImg);

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($publication);
            $manager->flush();

            $this->addFlash(
                'success',
                'La voyage a bien été modifiée'
            );

           
       
        return $this->redirectToRoute('profil');
        }
        return $this->render('profil/updatePublication.html.twig', [
            'publicationForm' => $form->createView(),
            'countrys' => $countrys,
            'publication'  => $publication
        ]);
    }

    /**
     * @Route("/profil/{id}", name="profil_voyageur")
     */
    public function afficheProfilVoyageur($id){

        $repo = $this->getDoctrine()->getRepository(Country::class);
        $countrys = $repo->findAll();
        $publications = $this->getDoctrine()->getManager()->getRepository(Publication::class)->findAll();
        $repo = $this->getDoctrine()->getRepository(User::class);
        $user = $repo->find($id);

        $datetime = date_format($user->getAge(), 'Y-m-d H:i:s');
        $timestamp = strtotime($datetime);
        $age = abs((time() - $timestamp) / (3600 * 24 * 365));
        $age = floor($age);

        return $this->render('profil/publierProfil.html.twig', [
            'user' => $user,
            'countrys' => $countrys,
            'publications' => $publications,
            'user_age' => $age,
        
        ]);
    }

}
