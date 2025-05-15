<?php

// namespace App\Tests\Controller;

// use App\Entity\Picture;
// use Doctrine\ORM\EntityManagerInterface;
// use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
// use Symfony\Component\HttpFoundation\File\UploadedFile;

// class PictureSmokeTest extends WebTestCase
// {
//     private EntityManagerInterface $manager;
//     private $client;

//     protected function setUp(): void
//     {
//         $this->client = self::createClient();

//         $this->manager = $this->client
//             ->getContainer()
//             ->get(EntityManagerInterface::class);
//     }


    // public function testNewPicture(): void
    // {
    //     $this->client->followRedirects();

    //     $this->client->request(
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
    //     $responseData = json_decode($this->client->getResponse()->getContent(), true);
    //     $apiToken = $responseData['apiToken'];

    //     // Vérifier que l'image originale existe avant de l'envoyer
    //     $originalImagePath = __DIR__ . '/../../tests/controller/me.jpg';
    //     if (!file_exists($originalImagePath)) {
    //         throw new \Exception("Le fichier de test 'me.jpg' n'existe pas à l'emplacement spécifié.");
    //     }

    //     // Créer un objet UploadedFile avec le bon type MIME
    //     $fileData = new UploadedFile(
    //         $originalImagePath,         // Fichier à envoyer
    //         'me.jpg',       // Nom du fichier
    //         'image/jpeg',           // Type MIME forcé
    //         null,
    //         true                    // Mode test pour éviter la vérification de l'upload
    //     );

    //     $this->client->request(
    //         'POST',
    //         '/api/picture',
    //         [
    //             'title' => 'test 1',
    //             'slug' => 'test-1',
    //             'restaurant_id' => 1,
    //             'food_id' => 1
    //         ],
    //         ['picture' => $fileData],
    //         [
    //             'CONTENT_TYPE' => 'multipart/form-data',
    //             'HTTP_X_AUTH_TOKEN' => $apiToken
    //         ],
    //     );
    // $statusCode = $client->getResponse()->getStatusCode();
    //     $this->assertEquals(201, $statusCode);
    //     $this->assertResponseIsSuccessful();
    // }

    // public function testShowPicture(): void
    // {
    //     $this->client->followRedirects();
    //     $this->client->request('GET', '/api/picture/1');
    // $statusCode = $client->getResponse()->getStatusCode();
    //     $this->assertEquals(200, $statusCode);
    //     $this->assertResponseIsSuccessful();
    // }

    // public function testUpdatePicture(): void
    // {
    //     $this->client->followRedirects();

    //     $this->client->request(
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

    //     $responseData = json_decode($this->client->getResponse()->getContent(), true);
    //     $apiToken = $responseData['apiToken'];

    //     //     // Vérifier que l'image originale existe avant de l'envoyer
    //     $originalImagePath = __DIR__ . '/../../tests/controller/new.jpg';
    //     if (!file_exists($originalImagePath)) {
    //         throw new \Exception("Le fichier de test 'new.jpg' n'existe pas à l'emplacement spécifié.");
    //     }

    //     //     // Créer un objet UploadedFile avec le bon type MIME
    //     $fileData = new UploadedFile(
    //         $originalImagePath,         // Fichier à envoyer
    //         'new.jpg',       // Nom du fichier
    //         'image/jpeg',           // Type MIME forcé
    //         null,
    //         true                    // Mode test pour éviter la vérification de l'upload
    //     );

    //     $this->client->request(
    //         'POST',
    //         '/api/picture/2',
    //         [
    //             'title' => 'test 1 updated',
    //             'slug' => 'test-1_updated',
    //             'restaurant_id' => 1,
    //             'food_id' => 1
    //         ],
    //         ['picture' => $fileData],
    //         [
    //             'CONTENT_TYPE' => 'application/json',
    //             'HTTP_X_AUTH_TOKEN' => $apiToken
    //         ]
    //     );
    // $statusCode = $client->getResponse()->getStatusCode();
        // $this->assertEquals(201, $statusCode);
    //     $this->assertResponseIsSuccessful();
    // }

    // public function testDeletePicture(): void
    // {
    //     $this->client->followRedirects();

    //     $this->client->request(
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

    //     $responseData = json_decode($this->client->getResponse()->getContent(), true);
    //     $apiToken = $responseData['apiToken'];

    //     $this->client->request(
    //         'DELETE',
    //         '/api/picture/1',
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
