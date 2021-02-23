<?php

namespace App\DataFixtures;

use App\Entity\Publication;
use App\Entity\User;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PublicationFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for($i = 1; $i <= 4; $i++){
        $id = $manager->find(User::class, 1);
     
        $publication = new Publication();
        $publication->setCountryName("japan n°$i")
                    ->setDate(new DateTime('02-06-2020'))
                    ->setDuration('3 jours')
                    ->setImg('http://placehold.it/350x150')
                    ->setUser($id);
                    

                    
                    

            $manager->persist($publication);
            }

        
        $manager->flush();
    }

}
