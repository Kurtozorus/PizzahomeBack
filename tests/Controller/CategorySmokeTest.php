<?php

// namespace App\Tests\Controller;

// use phpDocumentor\Reflection\Types\Void_;
// use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

// class CategorySmokeTest extends WebTestCase
// {
    // public function testNewCategory(): void
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
    //         '/api/category',
    //         [],
    //         [],
    //         [
    //             'CONTENT_TYPE' => 'application/json',
    //             'HTTP_X_AUTH_TOKEN' => $apiToken
    //         ],
    //         json_encode(
    //             [
    //                 'title' => 'entrée'
    //             ]
    //         )
    //     );
    // $statusCode = $client->getResponse()->getStatusCode();
    //     $this->assertEquals(201, $statusCode);
    //     $this->assertResponseIsSuccessful();
    // }

    // public function testGetCategories(): Void
    // {
    //     $client = self::createClient();
    //     $client->followRedirects(false);
    //     $client->request(
    //         'GET',
    //         '/api/category'
    //     );
    // $statusCode = $client->getResponse()->getStatusCode();
    //     $this->assertEquals(200, $statusCode);
    //     $this->assertResponseIsSuccessful();
    // }

    // public function testGetCategory(): Void
    // {
    //     $client = self::createClient();
    //     $client->followRedirects(false);
    //     $client->request(
    //         'GET',
    //         '/api/category/6'
    //     );
    // $statusCode = $client->getResponse()->getStatusCode();
    //     $this->assertEquals(200, $statusCode);
    //     $this->assertResponseIsSuccessful();
    // }

    // public function testEditCategory(): Void
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
    //         '/api/category/2',
    //         [],
    //         [],
    //         [
    //             'CONTENT_TYPE' => 'application/json',
    //             'HTTP_X_AUTH_TOKEN' => $apiToken
    //         ],
    //         json_encode(
    //             [
    //                 'title' => 'dessert'
    //             ]
    //         )
    //     );
    // $statusCode = $client->getResponse()->getStatusCode();
    //     $this->assertEquals(200, $statusCode);
    //     $this->assertResponseIsSuccessful();
    // }

    // public function testDeleteCategory(): Void
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
    //         '/api/category/3',
    //         [],
    //         [],
    //         [
    //             'CONTENT_TYPE' => 'application/json',
    //             'HTTP_X_AUTH_TOKEN' => $apiToken
    //         ]
    //     );
    // $statusCode = $client->getResponse()->getStatusCode();
    //     $this->assertEquals(204, $statusCode);
    //     $this->assertResponseIsSuccessful();
    // }
// }
