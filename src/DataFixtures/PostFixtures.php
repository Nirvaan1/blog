<?php

namespace App\DataFixtures;

use App\Entity\Post;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class PostFixtures extends Fixture
{

    public function load(ObjectManager $manager): void
    {
        $factory = Factory::create('fr_FR');
        for ($i = 0; $i < 10; $i++) {
            $post = new Post();
            $post->setTitle($factory->sentence)
                ->setAuthor($factory->firstName . ' '. $factory->lastName)
                ->setContent($factory->paragraphs)
                ->setLanguage($factory->country);

            $manager->persist($post);
        }
        $manager->flush();
    }

}
