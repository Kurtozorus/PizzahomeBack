<?php

namespace App\DataFixtures;

use App\Entity\Food;
use App\Entity\TakeAwayBooking;
use App\Entity\User;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Exception;

class TakeAwayBookingFixtures extends Fixture implements DependentFixtureInterface
{
    public const TakeAwayBooking_TUPLE = 20;
    public const TakeAwayBooking_REFERENCE = 'takeAwayBooking';

    /** @throws Exception */
    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i <= self::TakeAwayBooking_TUPLE; $i++) {
            $user = $this->getReference(UserFixtures::USER_REFERENCE . $i, User::class);
            $food = $this->getReference(FoodFixtures::FOOD_REFERENCE . $i, Food::class);
            $takeAwayBooking = (new TakeAwayBooking())
                ->setUser($user)
                ->addFood($food)
                ->setHourToRecover(new DateTimeImmutable('20:00'))
                ->setCreatedAt(new DateTimeImmutable());

            $manager->persist($takeAwayBooking);
        }
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
            RestaurantFixtures::class,
            FoodFixtures::class
        ];
    }
}
