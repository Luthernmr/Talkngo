<?php

namespace App\Controller;

use App\Entity\Country;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{
    /**
     * @Route("/admin/user", name="admin_user")
     */
    public function index(UserRepository $userRepository): Response
    { $repo = $this->getDoctrine()->getRepository(Country::class);
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
}
