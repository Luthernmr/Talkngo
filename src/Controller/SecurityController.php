<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\NewPassType;
use App\Form\ResetPassType;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;


use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    /**
     * @Route("/oublie-mdp", name="app_forgotten_password")
     */
    public function forgotPass(Request $Request,UserRepository $UserRepository, \Swift_Mailer $mailer,TokenGeneratorInterface $tokenGenerator){

        $form = $this->createForm(ResetPassType::class);
        $form->handleRequest($Request);

        if($form->isSubmitted() && $form->isValid()){

            $donnes = $form->getData();
            $user = $UserRepository->findOneByEmail($donnes['email']);

                // if($user == null){
                // $this->addFlash('danger', 'cette email n\'existe pas ');
                // $this->redirectToRoute('app_login');
                // }
                
            $token = $tokenGenerator->generateToken();

            if ($user !== null) {
                $user->setResetToken($token);
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($user);
                $entityManager->flush();
                
            } else {
                $this->addFlash('warning','une erreur est survenue:');
                return $this->redirectToRoute('app_login');
            }

           $url = $this->generateUrl('app_reset_password',['token' => $token]);


      //   ,UrlGeneratorInterface::ABSOLUTE_URL 
           $message = (new \Swift_Message('mot de passe oublié'))
           ->setFrom('talkngoprojet@gmail.com')
           ->setTo($user->getEmail())
           ->setBody(
            $this->renderView(
                'security/emailMdp.html.twig',['url' => $url]
            ),
            'text/html'
           );

           $mailer->send($message);
           $this->addFlash('message', 'un email de reinitialisation de mot de passe vous a éte envoyer ');

           return $this->redirectToRoute('app_login');

        }

        return $this->render('security/forgotPassword.html.twig', ['emailForm' => $form->createView()]);
    }  

     /**
     * @Route("/reset-mdp/{token}", name="app_reset_password")
     */
     public function resetPassword(Request $request, string $token, UserPasswordEncoderInterface $passwordEncoder){

        $form = $this->createForm(NewPassType::class);
        $form->handleRequest($request);

        $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(['reset_token' => $token]);

        if ($user !== null) {
            if($form->isSubmitted() && $form->isValid()) {
                $user->setResetToken(null);
                //  chiffre  mot de passe
               // $user->setPassword($passwordEncoder->encodePassword($user, $request->request->get('password')));
                $user->setPassword(
                    $passwordEncoder->encodePassword(
                        $user,
                        $form->get('password')->getData()
                    )
                );
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($user);
                $entityManager->flush();
                $this->addFlash('message', 'Mot de passe mis à jour');
                return $this->redirectToRoute('app_login');
            } else {
                return $this->render('security/newPassword.html.twig', [
                    'passwordForm' => $form->createView(),
                    'token' => $token
                ]);
            }
        } else {
            $this->addFlash('danger', 'Token Inconnu');
            return $this->redirectToRoute('app_login');
            
        }
    }
}
