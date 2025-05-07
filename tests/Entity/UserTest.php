<?php

// namespace App\Tests\Entity;

// use App\Entity\User;
// use App\Entity\Restaurant;
// use App\Entity\Booking;
// use App\Entity\TakeAwayBooking;
// use PHPUnit\Framework\TestCase;

// class UserTest extends TestCase
// {
//     public function testTheAutomaticApiTokenSettingWhenUserIsCreated(): void
//     {
//         $user = new User();
//         $this->assertNotNull($user->getApiToken());
//     }

//     public function testThanAnUserHasAtLeastOneRole(): void
//     {
//         $user = new User();
//         $this->assertContains('ROLE_USER', $user->getRoles());
//     }

//     public function testTheAutomaticDateTimeInStringWhenUserIsCreated(): void
//     {
//         $user = new User();
//         $this->assertNotNull($user->setCreatedAt(new \DateTimeImmutable()));
//         $this->assertNotNull($user->getCreatedAtDateString());
//     }

//     public function testTheAutomaticDateTimeInStringWhenUserIsUpdated(): void
//     {
//         $user = new User();
//         $this->assertNotNull($user->setCreatedAt(new \DateTimeImmutable()));
//         $this->assertNotNull($user->setUpdatedAt(new \DateTimeImmutable()));
//         $this->assertNotNull($user->getCreatedAtDateString());
//     }

//     public function testTheAutomaticRestaurantSettingWhenRestaurantIsCreated(): void
//     {
//         $user = new User();
//         $restaurant = new Restaurant();
//         $user->addRestaurant($restaurant);
//         $this->assertContains($restaurant, $user->getRestaurants());
//     }

//     public function testTheAutomaticBookingSettingWhenBookingIsCreated(): void
//     {
//         $user = new User();
//         $booking = new Booking();
//         $user->addBooking($booking);
//         $this->assertContains($booking, $user->getBookings());
//     }

//     public function testTheAutomaticTakeAwayBookingSettingWhenTakeAwayBookingIsCreated(): void
//     {
//         $user = new User();
//         $takeAwayBooking = new TakeAwayBooking();
//         $user->addTakeAwayBooking($takeAwayBooking);
//         $this->assertContains($takeAwayBooking, $user->getTakeAwayBookings());
//     }

//     public function testUserSetting(): void
//     {
//         $user = new User();
//         $user->setFirstName('John');
//         $user->setLastName('Doe');
//         $user->setEmail('H6I4o@example.com');
//         $user->setPassword('password');
//         $user->setAllergy('peanut');
//         $this->assertEquals('John', $user->getFirstName());
//         $this->assertEquals('Doe', $user->getLastName());
//         $this->assertEquals('H6I4o@example.com', $user->getEmail());
//         $this->assertEquals('password', $user->getPassword());
//         $this->assertEquals('peanut', $user->getAllergy());
//     }
// }
