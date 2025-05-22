<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Restaurant;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Exception;


class CategoryFixtures extends Fixture implements DependentFixtureInterface
{
    public const CATEGORY_NB_TUPLE = 20;
    public const CATEGORY_REFERENCE = 'category';

    /** @throws Exception */
    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i <= self::CATEGORY_NB_TUPLE; $i++) {
            $category = (new Category())
                ->setTitle("category $i")
                ->setCreatedAt(new DateTimeImmutable());


            $manager->persist($category);
            $this->addReference(
                self::CATEGORY_REFERENCE . $i,
                $category
            );
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
            RestaurantFixtures::class,
        ];
    }
}
