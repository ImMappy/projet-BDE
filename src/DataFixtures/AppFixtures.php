<?php

namespace App\DataFixtures;

use App\Entity\Sortie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class AppFixtures extends Fixture
{


        public function load(ObjectManager $manager): void
        {

            $faker = Faker\Factory::create('fr_FR');

            for($i = 0; $i < 30; $i++){
                $sortie[$i] = new Sortie();
                $sortie[$i]->setNom($faker->word);
                $sortie[$i]->setDateHeureDebut(new \DateTimeImmutable());
                $sortie[$i]->setDuree(mt_rand(0,20));
                $sortie[$i]->setDateLimiteInscription(new \DateTimeImmutable());
                $sortie[$i]->setNbInscriptionsMax(mt_rand(3,15));
                $sortie[$i]->setEtat("En cours");
                $sortie[$i]->setOrganisateur($sortie[$i]->getOrganisateur());
                $sortie[$i]->setInfosSortie($faker->text);
                $manager->persist($sortie[$i]);
            }
            $manager->flush();
        }
}
