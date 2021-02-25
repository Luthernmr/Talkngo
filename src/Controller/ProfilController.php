<?php

namespace App\Controller;

use App\Entity\Country;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProfilController extends AbstractController
{
    /**
     * @Route("/profil", name="profil")
     */
    public function index(): Response
    {
        $repo = $this->getDoctrine()->getRepository(Country::class);
        $countrys = $repo->findAll();
        $user = $this->getUser();
        return $this->render('profil/index.html.twig', [
            'controller_name' => 'ProfilController',
            'user' => $user,
            'countrys' => $countrys
        ]);
    }
}
