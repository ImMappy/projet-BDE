<?php

namespace App\DataFixtures;


use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker;
use Faker\Provider\fr_FR\Person;

class UserFixtures extends Fixture implements DependentFixtureInterface
{

    public function getDependencies()
    {
        // TODO: Implement getDependencies() method.
        return [
            CampusFixtures::class,

        ];
    }

    public function load(ObjectManager $manager): void
    {

        $faker = Faker\Factory::create('fr_FR');

        for($i = 0; $i < 30; $i++){
           $user[$i] = new User();
           $user[$i]->setNom($faker->lastName);
           $user[$i]->setPrenom($faker->firstName);
           $user[$i]->setPrenom($faker->phoneNumber);
           $user[$i]->setEmail($faker->email);
           $user[$i]->setPassword($faker->password);
           $user[$i]->setCampus($this->getReference(CampusFixtures::CAMPUS_REFERENCE));
           $user[$i]->setPrenom($faker->image(null, 640, 480));
            $manager->persist($user[$i]);
        }
        $manager->flush();
    }
}
