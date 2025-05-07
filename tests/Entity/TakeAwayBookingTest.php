<?php

namespace App\Tests\Entity;

use App\Entity\Food;
use App\Entity\TakeAwayBooking;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

class TakeAwayBookingTest extends TestCase
{
    public function testTheAutomaticTakeAwayBookingSetting(): void
    {
        $takeAwayBooking = new TakeAwayBooking();
        $food = new Food();
        $user = new User();
        $takeAwayBooking->setCreatedAt(new \DateTimeImmutable());
        $takeAwayBooking->setUpdatedAt(new \DateTimeImmutable());
        $takeAwayBooking->setUser($user);
        $takeAwayBooking->addFood($food);
        $takeAwayBooking->setHourToRecover(new \DateTimeImmutable('20:00'));
        $this->assertNotNull($takeAwayBooking->setCreatedAt(new \DateTimeImmutable()));
        $this->assertNotNull($takeAwayBooking->setUpdatedAt(new \DateTimeImmutable()));
        $this->assertNotNull($takeAwayBooking->setUser($user));
        $this->assertNotNull($takeAwayBooking->addFood($food));
        $this->assertNotNull($takeAwayBooking->setHourToRecover(new \DateTimeImmutable('20:00')));
    }
}
