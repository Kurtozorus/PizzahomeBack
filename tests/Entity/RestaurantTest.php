<?php

// namespace App\Tests\Entity;

// use App\Entity\Picture;
// use App\Entity\Restaurant;
// use App\Entity\User;
// use PHPUnit\Framework\TestCase;

// class RestaurantTest extends TestCase
// {
//     public function testTheAutomaticRestaurantSetting(): void
//     {
//         $restaurant = new Restaurant();
//         $restaurant->setName('test');
//         $restaurant->setDescription('test');
//         $restaurant->setAmOpeningTime(['10:00', '11:00']);
//         $restaurant->setPmOpeningTime(['12:00', '13:00']);
//         $restaurant->setMaxGuest(10);
//         $user = new User("john");
//         $restaurant->setOwner($user);
//         $this->assertEquals('test', $restaurant->getName());
//         $this->assertEquals('test', $restaurant->getDescription());
//         $this->assertEquals(['10:00', '11:00'], $restaurant->getAmOpeningTime());
//         $this->assertEquals(['12:00', '13:00'], $restaurant->getPmOpeningTime());
//         $this->assertEquals(10, $restaurant->getMaxGuest());
//         $this->assertNotNull($restaurant->getOwner());
//     }

//     public function testTheAutomaticDateTimeWhenRestaurantIsCreated(): void
//     {
//         $restaurant = new Restaurant();
//         $this->assertNotNull($restaurant->setCreatedAt(new \DateTimeImmutable()));
//         $this->assertNotNull($restaurant->setUpdatedAt(new \DateTimeImmutable()));
//         $this->assertNotNull($restaurant->getCreatedAt());
//         $this->assertNotNull($restaurant->getUpdatedAt());
//     }

//     public function testPictureSettingWhenRestaurantIsCreated(): void
//     {
//         $restaurant = new Restaurant();
//         $picture = new Picture();
//         $this->assertNotNull($restaurant->addPicture($picture));
//         $this->assertNotNull($restaurant->getPictures());
//     }
// }
