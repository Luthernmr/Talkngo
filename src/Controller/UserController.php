<?php

namespace App\Controller;

<<<<<<< HEAD
use App\Entity\Country;
=======
use App\Entity\User;

use App\Entity\Country;
use App\Form\UpdateAdminFormType;
use App\Form\RegistrationFormType;
>>>>>>> b44a7c50c82d8cac832c2bbade758fb00db66fda
use App\Repository\UserRepository;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends AbstractController
{
    /**
     * @Route("/admin/user", name="admin_user")
     */
    public function index(UserRepository $userRepository): Response
<<<<<<< HEAD
    { $repo = $this->getDoctrine()->getRepository(Country::class);
=======
    {
        $repo = $this->getDoctrine()->getRepository(Country::class);
>>>>>>> b44a7c50c82d8cac832c2bbade758fb00db66fda
        $countrys = $repo->findAll();
        $users = $userRepository->findAll();
        $utilisateurs = [];
        for ($i=0; $i<count($users); $i++) {
            $datetime = date_format($users[$i]->getAge(), 'Y-m-d H:i:s');
            $timestamp = strtotime($datetime);
            $utilisateurs['age'][$i] = abs((time() - $timestamp) / (3600 * 24 * 365));
        }
        $i = $i-1;
        return $this->render('admin/user.html.twig', [
            'users' => $users,
            'user_age' => $utilisateurs,
            'user_count' => $i,
            'countrys' => $countrys
        ]);
    }

     /**
     * @Route("/admin/user/create", name="create_user")
     */
    public function createUser(Request $request,UserPasswordEncoderInterface $passwordEncoder){

        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);
        $repo = $this->getDoctrine()->getRepository(Country::class);
        $countrys = $repo->findAll();

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            //gestion des images 
            $infoImg = $form['img']->getData(); // récupère les infos de l'image 
            $extensionImg = $infoImg->guessExtension(); // récupère le format de l'image 
            $nomImg = time() . '.' . $extensionImg; // compose un nom d'image unique
            $infoImg->move($this->getParameter('dossier_photos_user'), $nomImg); // déplace l'image
            $user->setImg($nomImg);
           

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
           
            return $this->redirectToRoute('admin_user');
        }

        return $this->render('admin/userCreate.html.twig', [
            'registrationForm' => $form->createView(),
            'countrys' =>$countrys
        ]);
    }
        

    /**
     * @Route("/admin/user/update-{id}", name="user_update") 
     */
    public function updateUser(UserRepository $userRepository, $id, Request $request)
    {
        $user = $userRepository->find($id);
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);
        $repo = $this->getDoctrine()->getRepository(Country::class);
        $countrys = $repo->findAll();

        if ($form->isSubmitted() && $form->isValid()) {
            $oldNomImg = $user->getImg(); //ancien image
            $oldCheminImg = $this->getParameter('dossier_photos_user') . '/' . $oldNomImg;

            if (file_exists($oldCheminImg)) {
                unlink($oldCheminImg);
            }

            $infoImg = $form['img']->getData();
            $extensionImg = $infoImg->guessExtension();

            $nomImg = time() . '.' . $extensionImg;
            $infoImg->move($this->getParameter('dossier_photos_user'), $nomImg);
            $user->setImg($nomImg);

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($user);
            $manager->flush();

            $this->addFlash(
                'success',
                'L\'utilisateur  a bien été modifiée'
            );

            return $this->redirectToRoute('admin_user');
        }
        return $this->render('admin/updateUser.html.twig', [
            'registrationForm' => $form->createView()
        ]);
    }

     /**
     * @Route("/admin/user/delete-{id}", name="user_delete") 
     */

     public function deleteUser(UserRepository $userRepository,$id){

        $user = $userRepository->find($id);
        $oldNomImg = $user->getImg();
        $oldCheminImg = $this->getParameter('dossier_photos_user') . '/' . $oldNomImg;

        if (file_exists($oldCheminImg)) {
            unlink($oldCheminImg);
        }

        $manager = $this->getDoctrine()->getManager();
        $manager->remove($user);
        $manager->flush();
        $this->addFlash(
            'success',
            'L\'utilisateur a bien été supprimée'
        );
        return $this->redirectToRoute('admin_user');
    }
     
}
