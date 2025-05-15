<?php

// namespace App\Tests\Controller;

// use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

// class BookingSmokeTest extends WebTestCase
// {
    // public function testNewBooking(): void
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
    //             ]
    //         )
    //     );
    //     $responseData = json_decode($client->getResponse()->getContent(), true);
    //     $apiToken = $responseData['apiToken'];

    //     $client->request(
    //         'POST',
    //         '/api/booking',
    //         [],
    //         [],
    //         [
    //             'CONTENT_TYPE' => 'application/json',
    //             'HTTP_X_AUTH_TOKEN' => $apiToken
    //         ],
    //         json_encode(
    //             [
    //                 'guestNumber' => 3,
    //                 'orderDate' => '2023-01-01',
    //                 'orderHour' => '12:00',
    //                 'guestAllergy' => 'gluten'
    //             ]
    //         )
    //     );
    //     $this->assertResponseIsSuccessful();
    // }
    // public function testGetBookings(): void
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
    //             ]
    //         )
    //     );
    //     $responseData = json_decode($client->getResponse()->getContent(), true);
    //     $apiToken = $responseData['apiToken'];

    //     $client->request(
    //         'GET',
    //         '/api/booking',
    //         [],
    //         [],
    //         [
    //             'CONTENT_TYPE' => 'application/json',
    //             'HTTP_X_AUTH_TOKEN' => $apiToken
    //         ]
    //     );
    //     $this->assertResponseIsSuccessful();
    // }

    // public function testGetBooking(): void
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
    //             ]
    //         )
    //     );
    //     $responseData = json_decode($client->getResponse()->getContent(), true);
    //     $apiToken = $responseData['apiToken'];

    //     $client->request(
    //         'GET',
    //         '/api/booking/1',
    //         [],
    //         [],
    //         [
    //             'CONTENT_TYPE' => 'application/json',
    //             'HTTP_X_AUTH_TOKEN' => $apiToken
    //         ]
    //     );
    //     $this->assertResponseIsSuccessful();
    // }

    // public function testEditBooking(): Void
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
    //             ]
    //         )
    //     );
    //     $responseData = json_decode($client->getResponse()->getContent(), true);
    //     $apiToken = $responseData['apiToken'];

    //     $client->request(
    //         'PUT',
    //         '/api/booking/1',
    //         [],
    //         [],
    //         [
    //             'CONTENT_TYPE' => 'application/json',
    //             'HTTP_X_AUTH_TOKEN' => $apiToken
    //         ],
    //         json_encode(
    //             [
    //                 'guestNumber' => 5,
    //                 'orderDate' => '2023-02-01',
    //                 'orderHour' => '18:00',
    //                 'guestAllergy' => 'crustacé'
    //             ]
    //         )
    //     );
    //     $this->assertResponseIsSuccessful();
    // }

    // public function testDeleteBooking(): void
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
    //             ]
    //         )
    //     );
    //     $responseData = json_decode($client->getResponse()->getContent(), true);
    //     $apiToken = $responseData['apiToken'];

    //     $client->request(
    //         'DELETE',
    //         '/api/booking/1',
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
