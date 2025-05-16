<?php

// namespace App\Tests\Controller;

// use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
// use Symfony\Component\Cache\Traits\RedisProxy;
// use Symfony\Component\HttpFoundation\RedirectResponse;

// class UserSmokeTest extends WebTestCase
// {
//     public function testUser(): void
//     {
//         $client = self::createClient();
//         $client->followRedirects(false);
//         $client->request('GET', '/api/doc');
//         self::assertResponseIsSuccessful();
//     }

// public function testRegistration(): void
// {
//     $client = self::createClient();
//     $client->followRedirects(false);
//     $client->request(
//         'POST',
//         '/api/registration',
//         [],
//         [],
//         ['CONTENT_TYPE' => 'application/json'],
//         json_encode(
//             [
//                 'email' => 'tatoO@example.com',
//                 'password' => 'password',
//                 'firstName' => 'dIn',
//                 'lastName' => 'Doe'
//             ],
//             JSON_THROW_ON_ERROR
//         )
//     );
// $this->assertResponseIsSuccessful();
//     self::assertResponseStatusCodeSame(201);
// }

// public function testLogin(): void
// {
//     $client = self::createClient();
//     $client->request(
//         'POST',
//         '/api/login',
//         [],
//         [],
//         ['CONTENT_TYPE' => 'application/json'],
//         json_encode(
//             [
//                 'username' => 'tatoO@example.com',
//                 'password' => 'password'
//             ],
//             JSON_THROW_ON_ERROR
//         )
//     );
// $statusCode = $client->getResponse()->getStatusCode();
// $this->assertEquals(200, $statusCode);
//     self::assertResponseIsSuccessful();
// }

//  public function testAccountMe(): void
//  {
//      $client = self::createClient();
//      $client->followRedirects(false);
//      $client->request(
//          'POST',
//          '/api/login',
//          [],
//          [],
//          ['CONTENT_TYPE' => 'application/json'],
//          json_encode(
//              [
//                  'username' => 'tatoO@example.com',
//                  'password' => 'password'
//              ],
//              JSON_THROW_ON_ERROR
//          )
//      );

//     $responseData = json_decode($client->getResponse()->getContent(), true);
//     $apiToken = $responseData['apiToken'];

//     $client->request(
//         'GET',
//         '/api/account/me',
//         [],
//         [],
//         [
//             'CONTENT_TYPE' => 'application/json',
//             'HTTP_X_AUTH_TOKEN' => $apiToken
//         ],
//     );
// $statusCode = $client->getResponse()->getStatusCode();
// $this->assertEquals(200, $statusCode);
//     self::assertResponseIsSuccessful();
// }
// public function testAccountEdit(): void
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
//                 'username' => 'tatoO@example.com',
//                 'password' => 'password'
//             ],
//             JSON_THROW_ON_ERROR
//         )
//     );
//     $responseData = json_decode($client->getResponse()->getContent(), true);
//     $apiToken = $responseData['apiToken'];

//     $client->request(
//         'PUT',
//         '/api/account/edit',
//         [],
//         [],
//         [
//             'CONTENT_TYPE' => 'application/json',
//             'HTTP_X_AUTH_TOKEN' => $apiToken
//         ],
//         json_encode(
//             [
//                 'password' => 'passk',
//                 'firstName' => 'Jane',
//                 'lastName' => 'Tita',
//                 'allergy' => 'peanut'
//             ],
//             JSON_THROW_ON_ERROR
//         )
//     );
// $statusCode = $client->getResponse()->getStatusCode();
// $this->assertEquals(200, $statusCode);
    //     self::assertResponseIsSuccessful();
    // }
    // public function testUserDelete(): void
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
    //                 'username' => 'tatoO@example.com',
    //                 'password' => 'passk',
    //             ],
    //             JSON_THROW_ON_ERROR
    //         )
    //     );
    //     $responseData = json_decode($client->getResponse()->getContent(), true);
    //     $apiToken = $responseData['apiToken'];
    //     $client->request(
    //         'DELETE',
    //         '/api/account/delete',
    //         [],
    //         [],
    //         [
    //             'CONTENT_TYPE' => 'application/json',
    //             'HTTP_X_AUTH_TOKEN' => $apiToken
    //         ],

    //     );
    // $statusCode = $client->getResponse()->getStatusCode();
    // $this->assertEquals(204, $statusCode);
    //     self::assertResponseIsSuccessful();
    // }
    // public function testCreateResponsable(): void
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
    //                 'username' => 'superadmin@hotmail.com',
    //                 'password' => '123456'
    //             ],
    //             JSON_THROW_ON_ERROR
    //         )
    //     );
    //     $responseData = json_decode($client->getResponse()->getContent(), true);
    //     $apiToken = $responseData['apiToken'];
    //     $client->request(
    //         'POST',
    //         '/api/admin/create-responsable',
    //         [],
    //         [],
    //         [
    //             'CONTENT_TYPE' => 'application/json',
    //             'HTTP_X_AUTH_TOKEN' => $apiToken
    //         ],
    //         json_encode(
    //             [
    //                 'email' => 'tatoti@example.com',
    //                 'password' => 'password',
    //                 'firstName' => 'John',
    //                 'lastName' => 'Doe'
    //             ],
    //             JSON_THROW_ON_ERROR
    //         )
    //     );
    // $statusCode = $client->getResponse()->getStatusCode();
    // $this->assertEquals(201, $statusCode);
    //     self::assertResponseIsSuccessful();
    // }
// }
