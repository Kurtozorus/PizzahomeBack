<?php

// namespace App\Tests\Controller;

// use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

// class RestaurantSmokeTest extends WebTestCase
// {
    // public function testCreateRestaurant(): void
    // {
    //     $client = static::createClient();
    //     $client->request(
    //         'POST',
    //         '/api/login',
    //         [],
    //         [],
    //         ['CONTENT_TYPE' => 'application/json'],
    //         json_encode(
    //             [
    //                 'username' => 'tatoti@example.com',
    //                 'password' => 'password',
    //             ],
    //             JSON_THROW_ON_ERROR
    //         )
    //     );
    //     $responseData = json_decode($client->getResponse()->getContent(), true);
    //     $apiToken = $responseData['apiToken'];

    //     $client->request(
    //         'POST',
    //         '/api/restaurant',
    //         [],
    //         [],
    //         [
    //             'CONTENT_TYPE' => 'application/json',
    //             'HTTP_X_AUTH_TOKEN' => $apiToken
    //         ],
    //         json_encode(
    //             [
    //                 'name' => 'New Restaurant',
    //                 'description' => 'New description',
    //                 'amOpeningTime' => ['12:00', '14:00'],
    //                 'pmOpeningTime' => ['18:00', '20:00'],
    //                 'maxGuest' => 10,
    //             ]
    //         )
    //     );
    //     $this->assertResponseIsSuccessful();
    // }
    // public function testShowRestaurant(): void
    // {
    //     $client = static::createClient();

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
    //         'GET',
    //         '/api/restaurant/1',
    //         [],
    //         [],
    //         ['CONTENT_TYPE' => 'application/json',
    //         'HTTP_X_AUTH_TOKEN' => $apiToken
    //         ]
    //     );
    //     $this->assertResponseIsSuccessful();
    // }

    // public function testUpdateRestaurant(): void
    // {
    //     $client = static::createClient();
    //     $client->followRedirects(true);
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
    //         '/api/restaurant/1',
    //         [],
    //         [],
    //         [
    //             'CONTENT_TYPE' => 'application/json',
    //             'HTTP_X_AUTH_TOKEN' => $apiToken
    //         ],
    //         json_encode(
    //             [
    //                 'name' => 'Super Restaurant',
    //                 'description' => 'Super description',
    //                 'amOpeningTime' => ['11:00', '14:00'],
    //                 'pmOpeningTime' => ['19:00', '20:00'],
    //                 'maxGuest' => 15
    //             ],
    //             JSON_THROW_ON_ERROR
    //         )

    //     );
    //     $this->assertResponseIsSuccessful();
    // }

    // public function testDeleteRestaurant(): void
    // {
    //     $client = static::createClient();
    //     $client->followRedirects(true);
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
    //         '/api/restaurant/1',
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
