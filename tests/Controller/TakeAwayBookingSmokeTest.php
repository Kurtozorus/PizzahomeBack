<?php

// namespace App\Tests\Controller;

// use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

// class TakeAwayBookingSmokeTest extends WebTestCase
// {
    // public function testNewTakeAwayBooking(): void
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
    //         'POST',
    //         '/api/takeawaybooking',
    //         [],
    //         [],
    //         [
    //             'CONTENT_TYPE' => 'application/json',
    //             'HTTP_X_AUTH_TOKEN' => $apiToken
    //         ],
    //         json_encode(
    //             [
    //                 'food' => [1],
    //                 'hourToRecover' => '20:50',
    //             ]
    //         )
    //     );
    //     $statusCode = $client->getResponse()->getStatusCode();
    //     $this->assertEquals(201, $statusCode);
    //     $this->assertResponseIsSuccessful();
    // }

    // public function testGetTakeAwayBookings(): void
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
    //         )
    //     );

    //     $responseData = json_decode($client->getResponse()->getContent(), true);
    //     $apiToken = $responseData['apiToken'];

    //     $client->request(
    //         'GET',
    //         '/api/takeawaybooking',
    //         [],
    //         [],
    //         [
    //             'CONTENT_TYPE' => 'application/json',
    //             'HTTP_X_AUTH_TOKEN' => $apiToken
    //         ]
    //     );
    //     $statusCode = $client->getResponse()->getStatusCode();
    //     $this->assertEquals(200, $statusCode);
    //     $this->assertResponseIsSuccessful();
    // }

    // public function testGetTakeAwayBooking(): void
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
    //         )
    //     );

    //     $responseData = json_decode($client->getResponse()->getContent(), true);
    //     $apiToken = $responseData['apiToken'];

    //     $client->request(
    //         'GET',
    //         '/api/takeawaybooking/1',
    //         [],
    //         [],
    //         [
    //             'CONTENT_TYPE' => 'application/json',
    //             'HTTP_X_AUTH_TOKEN' => $apiToken
    //         ]
    //     );
    //     $statusCode = $client->getResponse()->getStatusCode();
    //     $this->assertEquals(200, $statusCode);
    //     $this->assertResponseIsSuccessful();
    // }

    // public function testEditTakeAwayBooking(): void
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
    //         '/api/takeawaybooking/2',
    //         [],
    //         [],
    //         [
    //             'CONTENT_TYPE' => 'application/json',
    //             'HTTP_X_AUTH_TOKEN' => $apiToken
    //         ],
    //         json_encode(
    //             [
    //                 'food' => [1],
    //                 'hourToRecover' => '21:50',
    //             ]
    //         )
    //     );
    //     $statusCode = $client->getResponse()->getStatusCode();
    //     dd($statusCode);
    //     $this->assertEquals(200, $statusCode);
    //     $this->assertResponseIsSuccessful();
    // }

    // public function testDeleteTakeAwayBooking(): Void
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
    //         '/api/takeawaybooking/1',
    //         [],
    //         [],
    //         [
    //             'CONTENT_TYPE' => 'application/json',
    //             'HTTP_X_AUTH_TOKEN' => $apiToken
    //         ]
    //     );
    //     $statusCode = $client->getResponse()->getStatusCode();
    //     $this->assertEquals(204, $statusCode);
    //     $this->assertResponseIsSuccessful();
    // }
// }
