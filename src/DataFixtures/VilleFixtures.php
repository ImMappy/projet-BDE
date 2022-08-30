<?php

namespace App\DataFixtures;

use App\Entity\Sortie;
use App\Entity\Ville;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;
use Faker\Provider\fr_FR;

class VilleFixtures extends Fixture
{


    public function load(ObjectManager $manager): void
    {
        $villes= [["Saint-Herblain","44162"],["Quimper","29000"],["Chartres de Bretagne","35131"],["La Roche sur Yon","85000"],["Nantes","44000"],["Rennes","35238"]];

        for($i =0; $i < count($villes); $i++){
            $ville[$i] = new Ville();
            $ville[$i]->setCodePostal($villes[$i][1]);
            $ville[$i]->setNom($villes[$i][0]);
            $manager->persist($ville[$i]);
        }
        $manager->flush();
    }
}
