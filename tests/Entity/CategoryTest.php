<?php

// namespace App\Tests\Entity;

// use App\Entity\Category;
// use App\Entity\Food;
// use PHPUnit\Framework\TestCase;

// class CategoryTest extends TestCase
// {
//     public function testTheAutomaticCategorySetting(): void
//     {
//         $category = new Category();
//         $food = new Food();
//         $category->setTitle('test');
//         $category->setCreatedAt(new \DateTimeImmutable());
//         $category->setUpdatedAt(new \DateTimeImmutable());
//         $category->addFood($food);
//         $this->assertEquals('test', $category->getTitle());
//         $this->assertNotNull($category->setTitle('test'));
//         $this->assertNotNull($category->getCreatedAt());
//         $this->assertNotNull($category->getUpdatedAt());
//         $this->assertNotNull($category->getFood($food));
//     }
// }
