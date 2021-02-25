<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Country;
use App\Security\Authenticator;
use App\Form\RegistrationFormType;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegistrationController extends AbstractController
{

    /**
     * @Route("/register", name="app_register")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder, GuardAuthenticatorHandler $guardHandler, Authenticator $authenticator, \Swift_Mailer $Mailer): Response
    {
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

            // generer le token pour activer le compte 
            $user->setToken(md5(uniqid()));

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            // do anything else you need here, like send an email
            $message = (new \Swift_Message('comfirmation de votre email '))
             ->setFrom('talkngoprojet@gmail.com')
            ->setTo($user->getEmail())
            ->setBody(
                $this->renderView(
                    'registration/confirmation_email.html.twig',['token' => $user->getToken()]
                ),
                'text/html'
            )
           ;
           $Mailer->send($message);
           $this->addFlash('message',' creation de compte reuisssi,un email confirmation de mot de passe vous a éte envoyer ');

            return $guardHandler->authenticateUserAndHandleSuccess(
                $user,
                $request,
                $authenticator,
                'main' // firewall name in security.yaml
            );
            return $this->redirectToRoute('login');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
            'countrys' => $countrys
        ]);
    }

    /**
     * @Route("/activation/{token}", name="activation_compte")
     */
    public function activationCompte($token,UserRepository $userRepository){

        $user = $userRepository->findOneBy(['token' => $token ]);

        if(!$user){
            // On renvoie une erreur 
            throw $this->createNotFoundException('Cet utilisateur n\'existe pas');
        }
    
        // On supprime le token
        $user->setToken(null);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($user);
        $entityManager->flush();
    
        // On génère un message
        $this->addFlash('message', 'Utilisateur activé avec succès');
    
        // On retourne à l'accueil
        return $this->redirectToRoute('home');

    }
}
