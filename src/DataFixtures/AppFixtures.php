<?php

namespace App\DataFixtures;

use App\Entity\Sortie;
use App\Entity\Ville;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;
use Faker\Provider\fr_FR;

class AppFixtures extends Fixture
{


        public function load(ObjectManager $manager): void
        {

            $faker = Faker\Factory::create('fr_FR');

            for($i = 0; $i < 5; $i++){
               $ville[$i]= new Ville();
               $ville[$i]->setNom($faker->city);
               $ville[$i]->setCodePostal($faker->postcode);
               $manager->persist($ville[$i]);
            }
            $manager->flush();
        }
}
