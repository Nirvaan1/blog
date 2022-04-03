<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $factory = Factory::create('fr_FR');
        for ($i = 0; $i < 10; $i++) {
            $category = new Category();
            $category->setName($factory->sentence)
                ->setDescription($factory->paragraph)
            ;

            $manager->persist($category);
        }
        $manager->flush();
    }

}