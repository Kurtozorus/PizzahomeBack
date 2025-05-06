<?php

namespace App\Controller;

use App\Entity\Restaurant;
use App\Entity\User;
use App\Repository\RestaurantRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\{JsonResponse, Request, Response};
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/restaurant', name: 'app_api_restaurant_')]

final class RestaurantController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $manager,
        private RestaurantRepository $repository,
        private SerializerInterface $serializer,
        private UrlGeneratorInterface $urlGenerator,

    ) {}
    #[Route(name: 'new', methods: 'POST')]
    #[
        OA\Post(
            path: "/api/restaurant",
            summary: "Création d'un restaurant",
            requestBody: new OA\RequestBody(
                required: true,
                description: "Les données du restaurant pour sa création",
                content: new OA\MediaType(
                    mediaType: "application/json",
                    schema: new OA\Schema(
                        type: "object",
                        required: ["name", "description", "amOpeningTime", "pmOpeningTime", "maxGuest"],
                        properties: [
                            new OA\Property(
                                property: "name",
                                type: "string",
                                example: "Pizza Test"
                            ),
                            new OA\Property(
                                property: "description",
                                type: "string",
                                example: "Description du restaurant"
                            ),
                            new OA\Property(
                                property: "amOpeningTime",
                                type: "array",
                                items: new OA\Items(
                                    type: "string",
                                    example: ['12:00', '14:00']
                                )
                            ),
                            new OA\Property(
                                property: "pmOpeningTime",
                                type: "array",
                                items: new OA\Items(
                                    type: "string",
                                    example: ['20:00', '22:00']
                                )
                            ),
                            new OA\Property(
                                property: "maxGuest",
                                type: "integer",
                                example: 60
                            )
                        ]
                    )
                )
            ),
            responses: [
                new OA\Response(
                    response: "201",
                    description: "Restaurant créé avec succès",
                    content: new OA\MediaType(
                        mediaType: "application/json",
                        schema: new OA\Schema(
                            type: "object",
                            properties: [
                                new OA\Property(
                                    property: "name",
                                    type: "string",
                                    example: "Pizza Test"
                                ),
                                new OA\Property(
                                    property: "description",
                                    type: "string",
                                    example: "Description du restaurant"
                                ),
                                new OA\Property(
                                    property: "amOpeningTime",
                                    type: "array",
                                    items: new OA\Items(
                                        type: "string",
                                        example: ['12:00', '14:00']
                                    )
                                ),
                                new OA\Property(
                                    property: "pmOpeningTime",
                                    type: "array",
                                    items: new OA\Items(
                                        type: "string",
                                        example: ['20:00', '22:00']
                                    )
                                ),
                                new OA\Property(
                                    property: "maxGuest",
                                    type: "integer",
                                    example: 60
                                ),
                            ]
                        )
                    )
                )
            ]
        )
    ]
    public function new(Request $request, Security $security): JsonResponse
    {
        /** @var User $user */
        json_decode($request->getContent(), true);
        $restaurant = $this->serializer->deserialize($request->getContent(), Restaurant::class, 'json');
        $owner = $security->getUser();
        $restaurant->setOwner($owner);

        $restaurant->setCreatedAt(new DateTimeImmutable());

        $this->manager->persist($restaurant);
        $this->manager->flush();

        $responseData = $this->serializer->serialize(
            $restaurant,
            'json',
            ['groups' => ['restaurant']]
        );
        $location = $this->urlGenerator->generate(
            'app_api_restaurant_show',
            [
                'id' => $restaurant->getId(),
            ],
            UrlGeneratorInterface::ABSOLUTE_URL
        );
        return new JsonResponse($responseData, Response::HTTP_CREATED, ['Location' => $location], true);
    }


    #[Route('/{id}', name: 'show', methods: 'GET')]
    #[
        OA\Get(
            path: "/api/restaurant/{id}",
            summary: "Afficher le restaurant par son ID",
            parameters: [
                new OA\Parameter(
                    name: "id",
                    in: "path",
                    required: true,
                    description: "ID du restaurant a afficher",
                    schema: new OA\Schema(type: "integer")
                )
            ],
            responses: [
                new OA\Response(
                    response: "200",
                    description: "Restaurant trouvé avec succès",
                    content: new OA\MediaType(
                        mediaType: "application/json",
                        schema: new OA\Schema(
                            type: "object",
                            properties: [
                                new OA\Property(
                                    property: "name",
                                    type: "string",
                                    example: "Pizza Test"
                                ),
                                new OA\Property(
                                    property: "description",
                                    type: "string",
                                    example: "Description du restaurant"
                                ),
                                new OA\Property(
                                    property: "amOpeningTime",
                                    type: "array",
                                    items: new OA\Items(
                                        type: "string",
                                        example: ['12:00', '14:00']
                                    )
                                ),
                                new OA\Property(
                                    property: "pmOpeningTime",
                                    type: "array",
                                    items: new OA\Items(
                                        type: "string",
                                        example: ['20:00', '22:00']
                                    )
                                ),
                                new OA\Property(
                                    property: "maxGuest",
                                    type: "integer",
                                    example: 60
                                ),
                                new OA\Property(
                                    property: "createdAt",
                                    type: "string",
                                    example: "2025-04-24T19:09:11+02:00"
                                )
                            ]
                        )
                    )
                ),
                new OA\Response(
                    response: "404",
                    description: "Restaurant non trouvable"
                )
            ]
        )
    ]
    public function show(int $id): JsonResponse
    {
        $restaurant = $this->repository->findOneBy(["id" => $id]);
        if ($restaurant) {
            $responseData = $this->serializer->serialize($restaurant, 'json', ['groups' => ['restaurant']]);
            return new JsonResponse($responseData, Response::HTTP_OK, [], true);
        }

        return new JsonResponse(null, Response::HTTP_NOT_FOUND);
    }

    #[Route('/{id}', name: 'edit', methods: 'PUT')]
    #[
        OA\Put(
            path: "/api/restaurant/{id}",
            summary: "Modifier le restaurant par son ID",
            parameters: [
                new OA\Parameter(
                    name: "id",
                    in: "path",
                    required: true,
                    description: "ID du restaurant à modifier",
                    schema: new OA\Schema(type: "integer")
                )
            ],
            requestBody: new OA\RequestBody(
                required: true,
                description: "Les données du restaurant pour la modification",
                content: new OA\MediaType(
                    mediaType: "application/json",
                    schema: new OA\Schema(
                        type: "object",
                        required: ["name", "description", "amOpeningTime", "pmOpeningTime", "maxGuest"],
                        properties: [
                            new OA\Property(
                                property: "name",
                                type: "string",
                                example: "Pizza Test modifiée"
                            ),
                            new OA\Property(
                                property: "description",
                                type: "string",
                                example: "Description du restaurant modifiée"
                            ),
                            new OA\Property(
                                property: "amOpeningTime",
                                type: "array",
                                items: new OA\Items(
                                    type: "string",
                                    example: ['11:30', '14:00']
                                )
                            ),
                            new OA\Property(
                                property: "pmOpeningTime",
                                type: "array",
                                items: new OA\Items(
                                    type: "string",
                                    example: ['20:00', '23:00']
                                )
                            ),
                            new OA\Property(
                                property: "maxGuest",
                                type: "integer",
                                example: 40
                            )
                        ]
                    )
                )
            ),
            responses: [
                new OA\Response(
                    response: "200",
                    description: "Restaurant modifiée avec succès",
                    content: new OA\MediaType(
                        mediaType: "application/json",
                        schema: new OA\Schema(
                            type: "object",
                            properties: [
                                new OA\Property(
                                    property: "name",
                                    type: "string",
                                    example: "Pizza Test modifiée"
                                ),
                                new OA\Property(
                                    property: "description",
                                    type: "string",
                                    example: "Description du restaurant modifiée"
                                ),
                                new OA\Property(
                                    property: "amOpeningTime",
                                    type: "array",
                                    items: new OA\Items(
                                        type: "string",
                                        example: ['11:30', '14:00']
                                    )
                                ),
                                new OA\Property(
                                    property: "pmOpeningTime",
                                    type: "array",
                                    items: new OA\Items(
                                        type: "string",
                                        example: ['20:00', '23:00']
                                    )
                                ),
                                new OA\Property(
                                    property: "maxGuest",
                                    type: "integer",
                                    example: 40
                                ),
                                new OA\Property(
                                    property: "createdAt",
                                    type: "string",
                                    example: "2025-04-24T19:09:11+02:00"
                                ),
                                new OA\Property(
                                    property: "updatedAt",
                                    type: "string",
                                    example: "2025-04-24T19:09:11+02:00"
                                )
                            ]
                        )
                    )
                ),
                new OA\Response(
                    response: "404",
                    description: "Restaurant ou Utilisateur non trouvable"
                ),
            ]
        )
    ]
    public function edit(int $id, Request $request, Security $security): JsonResponse
    {
        $restaurant = $this->repository->findOneBy(["id" => $id]);

        json_decode($request->getContent(), true);
        if ($restaurant) {
            $restaurant = $this->serializer->deserialize(
                $request->getContent(),
                Restaurant::class,
                'json',
                [AbstractNormalizer::OBJECT_TO_POPULATE => $restaurant]
            );
            $owner = $security->getUser();
            $restaurant->setOwner($owner);
            $restaurant->setUpdatedAt(new DateTimeImmutable());


            $this->manager->flush();

            $responseData = $this->serializer->serialize(
                $restaurant,
                'json',
                ['groups' => ['restaurant']]
            );
            $location = $this->urlGenerator->generate(
                'app_api_restaurant_show',
                ['id' => $restaurant->getId()],
                UrlGeneratorInterface::ABSOLUTE_URL
            );
            return new JsonResponse($responseData, Response::HTTP_OK, ['Location' => $location], true);
        }
        return new JsonResponse(null, Response::HTTP_NOT_FOUND);
    }

    #[Route('/{id}', name: 'delete', methods: 'DELETE')]
    #[OA\Delete(
        path: '/api/restaurant/{id}',
        summary: 'Supprimer un restaurant',
        parameters: [
            new OA\Parameter(
                name: 'id',
                in: 'path',
                required: true
            ),
        ],
        responses: [
            new OA\Response(
                response: '200',
                description: 'Restaurant supprimé avec succès',
                content: new OA\MediaType(
                    mediaType: 'application/json',
                    schema: new OA\Schema(
                        type: 'object',
                        properties: [
                            new OA\Property(
                                property: 'status',
                                type: 'string',
                                example: 'succès'
                            ),
                            new OA\Property(
                                property: 'message',
                                type: 'string',
                                example: 'Le restaurant a été supprimé avec succès'
                            ),
                        ]
                    )
                )
            ),
            new OA\Response(
                response: "404",
                description: "Restaurant non trouvable"
            ),
        ]
    )]
    public function delete(int $id): JsonResponse
    {
        $restaurant = $this->repository->findOneBy(["id" => $id]);
        if ($restaurant) {
            $this->manager->remove($restaurant);
            $this->manager->flush();
            return new JsonResponse(['status' => 'succès', 'message' => 'Le restaurant a été supprimé avec succès'], Response::HTTP_OK);
        }

        return new JsonResponse(null, Response::HTTP_NOT_FOUND);
    }
}
