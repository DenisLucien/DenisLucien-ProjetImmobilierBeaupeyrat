<?php

namespace App\DataFixtures;

use App\Entity\Logement;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\DataFixtures\PhotosFixtures;
use App\Entity\Photos;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class LogementFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $photo = $this->getReference(PhotosFixtures::PHOTOS_REFERENCE, Photos::class);

        for ($i = 0; $i < 20; $i++) {
            $logement = new Logement();
            $logement->setTitle('logement ' . $i)
                ->setDescription(mt_rand(10, 100))
                ->setAddress("Avenue des lilas")
                ->setStatus("En vente")
                ->addPhoto($photo)
                ->setCreatedAt(new \DateTimeImmutable());
            $manager->persist($logement);
        }

        $manager->flush();
    }
    public function getDependencies(): array
    {
        return [
            PhotosFixtures::class,
        ];
    }
}
