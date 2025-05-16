<?php

// namespace App\Tests\Controller;

// use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

// class FoodSmokeTest extends WebTestCase
// {
    // public function testNewFood(): void
    // {
    //     $client = self::createClient();
    //     $client->followRedirects(false);
    //     $client->request(
    //         'POST',
    //         '/api/login',
    //         [],
    //         [],
    //         ['CONTENT_TYPE' => 'application/json'],
    //         json_encode(
    //             [
    //                 'username' => 'tatoti@example.com',
    //                 'password' => 'password'
    //             ]
    //         ),
    //         JSON_THROW_ON_ERROR
    //     );

    //     $responseData = json_decode($client->getResponse()->getContent(), true);
    //     $apiToken = $responseData['apiToken'];

    //     $client->request(
    //         'POST',
    //         '/api/food',
    //         [],
    //         [],
    //         [
    //             'CONTENT_TYPE' => 'application/json',
    //             'HTTP_X_AUTH_TOKEN' => $apiToken
    //         ],
    //         json_encode(
    //             [
    //                 'title' => 'test',
    //                 'description' => 'test',
    //                 'price' => 10.00,
    //                 'category' => 4
    //             ]
    //         )
    //     );
    //     $this->assertResponseIsSuccessful();
    // }

    // public function testShowFoods(): void
    // {
    //     $client = self::createClient();
    //     $client->followRedirects(true);
    //     $client->request(
    //         'GET',
    //         '/api/food',
    //         [],
    //         [],
    //         ['CONTENT_TYPE' => 'application/json']
    //     );
    //     $this->assertResponseIsSuccessful();
    // }

    // public function testGetFood(): void
    // {
    //     $client = self::createClient();
    //     $client->followRedirects(false);
    //     $client->request(
    //         'GET',
    //         '/api/food/6'
    //     );
    //     $this->assertResponseIsSuccessful();
    // }

    // public function testEditFood(): void
    // {
    //     $client = self::createClient();
    //     $client->followRedirects(false);
    //     $client->request(
    //         'POST',
    //         '/api/login',
    //         [],
    //         [],
    //         ['CONTENT_TYPE' => 'application/json'],
    //         json_encode(
    //             [
    //                 'username' => 'tatoti@example.com',
    //                 'password' => 'password'
    //             ],
    //             JSON_THROW_ON_ERROR
    //         )
    //     );

    //     $responseData = json_decode($client->getResponse()->getContent(), true);
    //     $apiToken = $responseData['apiToken'];

    //     $client->request(
    //         'PUT',
    //         '/api/food/2',
    //         [],
    //         [],
    //         [
    //             'CONTENT_TYPE' => 'application/json',
    //             'HTTP_X_AUTH_TOKEN' => $apiToken
    //         ],
    //         json_encode(
    //             [
    //                 'title' => 'frite',
    //                 'description' => 'plat de frite',
    //                 'price' => 6.00,
    //                 'category' => 1
    //             ]
    //         )
    //     );
    //     $this->assertResponseIsSuccessful();
    // }

    // public function testDeleteFood(): void
    // {
    //     $client = self::createClient();
    //     $client->followRedirects(false);
    //     $client->request(
    //         'POST',
    //         '/api/login',
    //         [],
    //         [],
    //         ['CONTENT_TYPE' => 'application/json'],
    //         json_encode(
    //             [
    //                 'username' => 'tatoti@example.com',
    //                 'password' => 'password'
    //             ],
    //             JSON_THROW_ON_ERROR
    //         )
    //     );

    //     $responseData = json_decode($client->getResponse()->getContent(), true);
    //     $apiToken = $responseData['apiToken'];
    //     $client->request(
    //         'DELETE',
    //         '/api/food/2',
    //         [],
    //         [],
    //         [
    //             'CONTENT_TYPE' => 'application/json',
    //             'HTTP_X_AUTH_TOKEN' => $apiToken
    //         ]
    //     );
    //     $this->assertResponseIsSuccessful();
    // }


// }
