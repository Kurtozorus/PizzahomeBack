<?php

namespace App\DataFixtures;

use App\Entity\User;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Exception;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public const USER_NB_TUPLE = 20;
    public const USER_REFERENCE = 'user';
    public function __construct(private UserPasswordHasherInterface $passwordHasher) {}
    /** @throws Exception */
    public function load(ObjectManager $manager): void
    {
        $randomRoles =
            [
                ["ROLE_USER"],
                ["ROLE_USER", "ROLE_RESPONSABLE"],
            ];
        for ($i = 1; $i <= self::USER_NB_TUPLE; $i++) {
            $randomChoice = $randomRoles[array_rand($randomRoles)];
            $user = (new User())
                ->setFirstName("firstName  $i")
                ->setLastName("lastName  $i")
                ->setEmail("email$i@example.com")

                ->setCreatedAt(new DateTimeImmutable());

            $user->setPassword($this->passwordHasher->hashPassword($user, "password $1"));
            $user->setRoles($randomChoice);

            $manager->persist($user);
            $this->addReference(self::USER_REFERENCE . $i, $user);
        }

        $manager->flush();
    }
}
