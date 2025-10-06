<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture implements FixtureGroupInterface
{
    public function __construct(private UserPasswordHasherInterface $passwordHasher) {}

    public static function getGroups(): array
    {
        return ['users', 'dev'];
    }

    public function load(ObjectManager $manager): void
    {

        $user = new User();
        $hashedPassword = $this->passwordHasher->hashPassword($user, "AdminPwd135<");
        $user->setEmail('admin@gmail.com')
            ->setRoles(["ROLE_ADMIN"])
            ->setPassword($hashedPassword);;
        $manager->persist($user);


        $manager->flush();
    }
}
