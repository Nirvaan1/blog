<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public function __construct(
        private UserPasswordHasherInterface $userPasswordHasher
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 1; $i++) {
            $user = new User();
            $user->setEmail('admin@hotmail.fr');
            $user->setRoles(['ROLE_ADMIN']);
            $plaintextPassword = 'password';

            // hash the password (based on the security.yaml config for the $user class)
            $hashedPassword = $this->userPasswordHasher->hashPassword(
                $user,
                $plaintextPassword
            );
            $user->setPassword($hashedPassword);
            $manager->persist($user);
        }
        $manager->flush();
    }

}
