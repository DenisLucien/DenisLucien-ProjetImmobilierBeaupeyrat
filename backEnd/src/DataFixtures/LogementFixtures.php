<?php

namespace App\DataFixtures;

use App\Entity\Logement;
use App\Entity\Photos;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
     public function load(ObjectManager $manager): void
    {
        
        for ($i = 0; $i < 20; $i++) {
            $logement = new Logement();
            $logement->setTitle('logement '.$i)
            ->setDescription(mt_rand(10, 100))
            ->setAddress("Avenue des lilas")
            ->setStatus("En vente");
            $photo=new Photos();
            $photo->setSource("");
            $logement->AddPhoto($photo);
            $manager->persist($logement);
        }

        $manager->flush();
    }
}
