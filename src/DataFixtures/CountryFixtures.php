<?php

namespace App\DataFixtures;

use App\Entity\Country;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CountryFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        for($i = 1; $i<=4; $i++ ){
            $country = new Country();
            $country->setCountryName('Japan')
                    ->setCountryNameFr('japon');
        }

        $manager->persist($country);

        $manager->flush();
    }
}
