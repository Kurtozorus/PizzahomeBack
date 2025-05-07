<?php

namespace App\Tests\Entity;

use App\Entity\Booking;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

class BookingTest extends TestCase
{
    public function testTheAutomaticBookingSetting(): void
    {
        $booking = new Booking();
        $user = new User();
        $booking->setGuestNumber(2);
        $booking->setOrderDate(new \DateTimeImmutable('2022-01-01'));
        $booking->setOrderHour(new \DateTimeImmutable('2022-01-01 12:00:00'));
        $booking->setGuestAllergy('peanut');
        $booking->setCreatedAt(new \DateTimeImmutable('2022-01-01'));
        $booking->setUpdatedAt(new \DateTimeImmutable('2022-01-01'));
        $booking->addUser($user);
        $this->assertEquals(2, $booking->getGuestNumber());
        $this->assertEquals(new \DateTimeImmutable('2022-01-01'), $booking->getOrderDate());
        $this->assertEquals(new \DateTimeImmutable('2022-01-01 12:00:00'), $booking->getOrderHour());
        $this->assertNotNull($booking->getOrderHourString());
        $this->assertEquals('peanut', $booking->getGuestAllergy());
        $this->assertNotNull(($booking->getGuestAllergy()));
        $this->assertEquals(new \DateTimeImmutable('2022-01-01'), $booking->getCreatedAt());
        $this->assertEquals(new \DateTimeImmutable('2022-01-01'), $booking->getUpdatedAt());
        $this->assertContains($user, $booking->getUser());
    }
}
