<?php

namespace App\DataFixtures;


use App\Entity\Etat;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;


class EtatFixtures extends Fixture
{


    public function load(ObjectManager $manager): void
    {

       $etats = ["Crée","Ouverte","Cloturée","Activité en cours","Passée","Annulée"];

        for($i = 0; $i < count($etats); $i++){
            $etat[$i] = new Etat();
            $etat[$i]->setLibelle($etats[$i]);
            $manager->persist($etat[$i]);
        }
        $manager->flush();
    }
}
