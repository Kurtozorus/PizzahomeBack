<?php

namespace App\DataFixtures;

use App\Entity\Restaurant;
use App\Entity\User;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Exception;


class RestaurantFixtures extends Fixture implements DependentFixtureInterface
{
    public const RESTAURANT_NB_TUPLE = 20;
    public const RESTAURANT_REFERENCE = 'restaurant';

    /** @throws Exception */
    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i <= UserFixtures::USER_NB_TUPLE; $i++) {
            $user = $this->getReference(UserFixtures::USER_REFERENCE . $i, User::class);
            if (in_array("ROLE_RESPONSABLE", $user->getRoles(), true)) {
                $responsables[] = $user;
            }
        }

        // Sécurité : vérifie qu'il y a au moins un responsable
        if (empty($responsables)) {
            throw new \Exception('Aucun utilisateur avec le rôle ROLE_RESPONSABLE trouvé.');
        }

        for ($i = 1; $i <= self::RESTAURANT_NB_TUPLE; $i++) {
            $restaurant = (new Restaurant())
                ->setName("restaurant  $i")
                ->setDescription("description  $i")
                ->setAmOpeningTime(['10:00', '11:00'])
                ->setPmOpeningTime(['12:00', '13:00'])
                ->setMaxGuest(random_int(10, 50))
                ->setOwner($responsables[array_rand($responsables)])
                ->setCreatedAt(new DateTimeImmutable());


            $manager->persist($restaurant);
            $this->addReference(
                self::RESTAURANT_REFERENCE . $i,
                $restaurant
            );
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
        ];
    }
}
