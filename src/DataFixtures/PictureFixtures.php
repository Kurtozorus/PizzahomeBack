<?php

namespace App\DataFixtures;

use App\Entity\Food;
use App\Entity\Picture;
use App\Entity\Restaurant;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Exception;


class PictureFixtures extends Fixture implements DependentFixtureInterface
{
    const PICTURE_NB_TUPLE = 20;
    /** @throws Exception */
    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i <= self::PICTURE_NB_TUPLE; $i++) {
            /** @var Restaurant $restaurant */
            $restaurant = $this->getReference(
                RestaurantFixtures::RESTAURANT_REFERENCE . $i,
                Restaurant::class
            );
            $food = $this->getReference(
                FoodFixtures::FOOD_REFERENCE . $i,
                Food::class
            );
            $picture = (new Picture())
                ->setPublicPath("/http://127.0.0.1:8000/uploads/pictures/680a70c9c1c742.1607453$i.webp")
                ->setLocalPath("680a70c9c1c742.1607453$i.webp")
                ->setTitle("image numéro  $i")
                ->setSlug("image-numero $i")
                ->setRestaurant($restaurant)
                ->setFood($food)
                ->setCreatedAt(new DateTimeImmutable());


            $manager->persist($picture);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            RestaurantFixtures::class,
            FoodFixtures::class
        ];
    }
}
