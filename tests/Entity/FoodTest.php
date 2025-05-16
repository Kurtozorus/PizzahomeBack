<?php

// namespace App\Tests\Entity;

// use App\Entity\Booking;
// use App\Entity\Category;
// use App\Entity\Food;
// use App\Entity\Picture;
// use App\Entity\TakeAwayBooking;
// use PHPUnit\Framework\TestCase;

// class FoodTest extends TestCase
// {
//     public function testTheAutomaticFoodSetting(): void
//     {
//         $food = new Food();
//         $category = new Category();
//         $takeAwayBooking = new TakeAwayBooking();
//         $picture = new Picture();
//         $food->setTitle('test');
//         $food->setDescription('test');
//         $food->setPrice(10);
//         $food->setCreatedAt(new \DateTimeImmutable());
//         $food->setUpdatedAt(new \DateTimeImmutable());
//         $food->setCategory($category);
//         $food->addTakeAwayBooking($takeAwayBooking);
//         $food->addPicture($picture);
//         $this->assertNotNull($food->setTitle('test'));
//         $this->assertNotNull($food->setDescription('test'));
//         $this->assertNotNull($food->setPrice(10));
//         $this->assertIsFloat($food->getPrice());
//         $this->assertNotNull($food->setCreatedAt(new \DateTimeImmutable()));
//         $this->assertNotNull($food->setUpdatedAt(new \DateTimeImmutable()));
//         $this->assertNotNull($food->setCategory($category));
//         $this->assertNotNull($food->addTakeAwayBooking($takeAwayBooking));
//         $this->assertNotNull($food->addPicture($picture));
//     }
// }
