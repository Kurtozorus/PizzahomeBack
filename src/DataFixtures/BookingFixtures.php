<?php

namespace App\DataFixtures;

use App\Entity\Booking;
use App\Entity\User;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Exception;


class BookingFixtures extends Fixture implements DependentFixtureInterface
{
    public const BOOKING_NB_TUPLE = 20;
    public const BOOKING_REFERENCE = 'booking';

    /** @throws Exception */
    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i <= self::BOOKING_NB_TUPLE; $i++) {
            $user = $this->getReference(UserFixtures::USER_REFERENCE . $i, User::class);
            $booking = (new Booking())
                ->addUser(($user))
                ->setGuestNumber(random_int(1, 10))
                ->setOrderHour(new DateTimeImmutable())
                ->setOrderDate(new DateTimeImmutable())
                ->setGuestAllergy("allergy $i")
                ->setCreatedAt(new DateTimeImmutable());

            $manager->persist($booking);
        };
        $manager->flush($booking);
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
