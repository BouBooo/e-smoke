<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Mark;
use App\Entity\Liquid;
use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class LiquidFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        for($k = 1; $k < 4; $k++) {
            $mark = new Mark();
            $mark
                ->setName($faker->word());

            $manager->persist($mark);

            for($i = 1; $i <= 3; $i++) {
                $category = new Category();
                $category
                    ->setName($faker->word());

                $manager->persist($category);

                for($j = 1; $j < 15; $j++) {
                    $liquid = new Liquid();
                    $liquid
                        ->setName($faker->word())
                        ->setFlavor($faker->words(2, true))
                        ->setPrice($faker->randomDigit())
                        ->setCategory($category)
                        ->setMark($mark)
                        ->setImage($faker->imageUrl());

                    $manager->persist($liquid);
                }
            }
        }
           

        $manager->flush();
    }
}
