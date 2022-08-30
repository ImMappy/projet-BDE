<?php

namespace App\DataFixtures;

use App\Entity\Campus;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;


class CampusFixtures extends Fixture
{
    public const CAMPUS_REFERENCE = 'campus';
    public function load(ObjectManager $manager): void
    {
        $campuses= ["Saint-Herblain","Quimper","Chartres de Bretagne","La Roche sur Yon"];


        for($i =0; $i < count($campuses); $i++){
            $campus[$i] = new Campus();
            $campus[$i]->setNom($campuses[$i]);
            $this->setReference(self::CAMPUS_REFERENCE, $campus[$i]);

            $manager->persist($campus[$i]);
        }
        $manager->flush();
    }
}
