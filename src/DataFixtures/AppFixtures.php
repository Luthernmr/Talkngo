<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        for ($i=0; $i <= 5; $i++)
        {
            $user = new User();{
                $user->setName('Nom');
                $user->setFirstName('Prenom');
                $user->setEmail('Email'. $i);
                $user->setAge(new \DateTime('1983-03-04'));
                $user->setLocation('location');
                $user->setDescription('description');
                $user->setPassword('mot de passe');
                $user->setImg('image');
                $manager->persist($user);
            }
        }
        $manager->flush();
    }
}