<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Food;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Exception;


class FoodFixtures extends Fixture implements DependentFixtureInterface
{
    public const FOOD_NB_TUPLE = 20;
    public const FOOD_REFERENCE = 'food';

    /** @throws Exception */
    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i <= self::FOOD_NB_TUPLE; $i++) {
            $category = $this->getReference(
                CategoryFixtures::CATEGORY_REFERENCE . $i,
                Category::class
            );
            $food = (new Food())
                ->setTitle("food . $i")
                ->setDescription("description . $i")
                ->setPrice(random_int(10, 20))
                ->setCreatedAt(new DateTimeImmutable())
                ->setCategory($category);
            $manager->persist($food);
            $this->addReference(
                self::FOOD_REFERENCE . $i,
                $food
            );
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            CategoryFixtures::class,
        ];
    }
}
