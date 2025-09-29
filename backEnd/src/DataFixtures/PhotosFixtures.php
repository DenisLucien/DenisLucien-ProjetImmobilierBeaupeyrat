<?php

namespace App\DataFixtures;

use App\Entity\Photos;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PhotosFixtures extends Fixture
{
    public const PHOTOS_REFERENCE = 'photoBase';
    public function load(ObjectManager $manager): void
    {

        $photo = new Photos();
        $photo->setSource("/uploads/logementBase.jpg");
        $manager->persist($photo);
        $this->addReference(self::PHOTOS_REFERENCE, $photo);
        $manager->flush();
    }
}
