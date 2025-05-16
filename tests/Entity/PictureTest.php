<?php

// namespace App\Tests\Entity;

// use App\Entity\Food;
// use App\Entity\Picture;
// use App\Entity\Restaurant;
// use PHPUnit\Framework\TestCase;

// class PictureTest extends TestCase
// {
//     public function testTheAutomaticPictureSetting(): void
//     {
//         $picture = new Picture();
//         $restaurant = new Restaurant();
//         $food = new Food();
//         $picture->setPublicPath('/http://127.0.0.1:8000/uploads/pictures/680a70c9c1c742.16074531.webp');
//         $picture->setLocalPath('680a70c9c1c742.16074531.webp');
//         $picture->setTitle('test réussie');
//         $picture->setSlug('test-reussie');
//         $this->assertNotNull($picture->setCreatedAt(new \DateTimeImmutable()));
//         $this->assertNotNull($picture->setUpdatedAt(new \DateTimeImmutable()));
//         $this->assertNotNull($picture->getCreatedAt());
//         $this->assertNotNull($picture->getUpdatedAt());
//         $this->assertNotNull($picture->getPublicPath());
//         $this->assertNotNull($picture->getLocalPath());
//         $this->assertNotNull($picture->getTitle());
//         $this->assertNotNull($picture->getSlug());
//         $this->assertNotNull($picture->setRestaurant($restaurant));
//         $this->assertNotNull($picture->getRestaurant());
//         $this->assertNotNull($picture->setFood($food));
//         $this->assertNotNull($picture->getFood());
//     }
// }
