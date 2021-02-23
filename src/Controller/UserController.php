<?php

namespace App\Controller;

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
    {
        $users = $userRepository->findAll();
        $utilisateurs = [];
        $user_id = [];
        for ($i=0; $i<count($users); $i++) {
            $datetime = date_format($users[$i]->getAge(), 'Y-m-d H:i:s');
            $timestamp = strtotime($datetime);
            $utilisateurs['age'][$i] = abs((time() - $timestamp) / (3600 * 24 * 365));
        }

        return $this->render('admin/user.html.twig', [
            'users' => $users,
            'user_age' => $utilisateurs,
            'u_id' => $user_id
        ]);
    }
}
