<?php

namespace App\Controller;

use App\Entity\Food;
use App\Entity\TakeAwayBooking;
use App\Repository\TakeAwayBookingRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use OpenApi\Attributes as OA;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/takeawaybooking', name: 'app_api_take_away_booking_')]
final class TakeAwayBookingController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $manager,
        private TakeAwayBookingRepository $repository,
        private SerializerInterface $serializer,
        private UrlGeneratorInterface $urlGenerator
    ) {}
    #[Route(name: 'index', methods: ['GET'])]
    #[
        OA\Get(
            path: '/api/takeawaybooking',
            summary: 'Voir la liste des commandes',
            responses: [
                new OA\Response(
                    response: '200',
                    description: 'Liste des commandes à emporter',
                    content: new OA\MediaType(
                        mediaType: 'application/json',
                        schema: new OA\Schema(
                            type: 'array',
                            items: new OA\Items(
                                type: 'object',
                                properties: [
                                    new OA\Property(
                                        property: 'id',
                                        type: 'integer',
                                        example: 1
                                    ),
                                    new OA\Property(
                                        property: 'food',
                                        type: 'array',
                                        items: new OA\Items(
                                            type: 'object',
                                            properties: [
                                                new OA\Property(
                                                    property: 'title',
                                                    type: 'string',
                                                    example: 'Poulet'
                                                ),
                                                new OA\Property(
                                                    property: 'description',
                                                    type: 'string',
                                                    example: 'Poulet frit'
                                                ),
                                                new OA\Property(
                                                    property: 'price',
                                                    type: 'float',
                                                    example: 5.99
                                                ),
                                                new OA\Property(
                                                    property: 'createdAt',
                                                    type: 'string',
                                                    format: 'date-time',
                                                    example: '2023-01-01T00:00:00+00:00'
                                                ),
                                                new OA\Property(
                                                    property: 'updatedAt',
                                                    type: 'string',
                                                    format: 'date-time',
                                                    example: '2023-01-01T00:00:00+00:00'
                                                ),
                                                new OA\Property(
                                                    property: 'category',
                                                    type: 'object',
                                                    properties: [
                                                        new OA\Property(
                                                            property: 'id',
                                                            type: 'integer',
                                                            example: '1'
                                                        ),
                                                        new OA\Property(
                                                            property: 'title',
                                                            type: 'string',
                                                            example: 'Entrée'
                                                        )
                                                    ]
                                                )

                                            ]
                                        )
                                    ),
                                    new OA\Property(
                                        property: 'user',
                                        type: 'object',
                                        properties: [
                                            new OA\Property(
                                                property: 'firstName',
                                                type: 'string',
                                                example: 'John'
                                            ),
                                            new OA\Property(
                                                property: 'lastName',
                                                type: 'string',
                                                example: 'Doe'
                                            )
                                        ]
                                    ),
                                    new OA\Property(
                                        property: 'createdAt',
                                        type: 'string',
                                        format: 'date-time',
                                        example: '2023-01-01T00:00:00+00:00'
                                    ),
                                    new OA\Property(
                                        property: 'hourToRecoverString',
                                        type: 'string',
                                        example: '12:30'
                                    )
                                ]
                            )
                        )
                    )
                )
            ]
        )
    ]
    public function index(): JsonResponse
    {
        $takeAwayBookings = $this->manager->getRepository(TakeAwayBooking::class)->findAll();
        $takeAwayBookings = $this->serializer->serialize($takeAwayBookings, 'json', ['groups' => ['takeAwayBookings', 'category', 'food', 'user:read']]);
        return new JsonResponse($takeAwayBookings, Response::HTTP_OK, [], true);
    }

    #[Route(name: 'new', methods: 'POST')]
    #[
        OA\Post(
            path: "/api/takeawaybooking",
            summary: "Créer une nouvelle reservation à emporter",
            requestBody: new OA\RequestBody(
                required: true,
                description: "Les données de la reservation à emporter pour sa création",
                content: new OA\MediaType(
                    mediaType: "application/json",
                    schema: new OA\Schema(
                        type: "object",
                        required: ["food", "hourToRecover"],
                        properties: [
                            new OA\Property(
                                property: "food",
                                type: "array",
                                items: new OA\Items(
                                    type: "integer",
                                    example: [1, 2, 3]
                                )
                            ),
                            new OA\Property(
                                property: "hourToRecover",
                                type: "string",
                                format: "date-time",
                                example: "20:50"
                            )
                        ]
                    )
                )
            ),
            responses: [
                new OA\Response(
                    response: '201',
                    description: 'Reservation à emporter crée avec succès',
                    content: new OA\MediaType(
                        mediaType: 'application/json',
                        schema: new OA\Schema(
                            type: 'object',
                            properties: [
                                new OA\Property(
                                    property: 'id',
                                    type: 'integer',
                                    example: 1
                                ),
                                new OA\Property(
                                    property: 'food',
                                    type: 'array',
                                    items: new OA\Items(
                                        type: 'object',
                                        properties: [
                                            new OA\Property(
                                                property: 'title',
                                                type: 'string',
                                                example: 'Pizza'
                                            ),
                                            new OA\Property(
                                                property: 'description',
                                                type: 'string',
                                                example: 'Pizza au fromage'
                                            ),
                                            new OA\Property(
                                                property: 'price',
                                                type: 'float',
                                                example: 10.50
                                            ),
                                            new OA\Property(
                                                property: 'createdAt',
                                                type: 'string',
                                                format: 'date-time',
                                                example: '2023-01-01T00:00:00+00:00'
                                            ),
                                            new OA\Property(
                                                property: 'updatedAt',
                                                type: 'string',
                                                format: 'date-time',
                                                example: '2023-01-01T00:00:00+00:00'
                                            ),
                                            new OA\Property(
                                                property: 'category',
                                                type: 'object',
                                                properties: [
                                                    new OA\Property(
                                                        property: 'id',
                                                        type: 'integer',
                                                        example: 1
                                                    ),
                                                    new OA\Property(
                                                        property: 'title',
                                                        type: 'string',
                                                        example: 'Entrée'
                                                    ),
                                                ]
                                            )
                                        ]
                                    )
                                ),
                                new OA\Property(
                                    property: 'user',
                                    type: 'object',
                                    properties: [
                                        new OA\Property(
                                            property: 'firstName',
                                            type: 'string',
                                            example: 'John'
                                        ),
                                        new OA\Property(
                                            property: 'lastName',
                                            type: 'string',
                                            example: 'Doe'
                                        )
                                    ]
                                ),
                                new OA\Property(
                                    property: 'createdAt',
                                    type: 'string',
                                    format: 'date-time',
                                    example: '2023-01-01T00:00:00+00:00'
                                ),
                                new OA\Property(
                                    property: 'hourToRecoverString',
                                    type: 'string',
                                    example: '20:50'
                                )
                            ]
                        )
                    )
                ),
                new OA\Response(
                    response: '400',
                    description: 'Le plat est introuvable'
                )
            ]
        )
    ]
    public function new(Request $request, Security $security): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        /** @var TakeAwayBooking $takeAwayBooking */
        $takeAwayBooking = new TakeAwayBooking();

        $user = $security->getUser();
        $takeAwayBooking->setUser($user);
        /** @var Food $food */
        $foods = $this->manager->getRepository(Food::class)->findByIds($data['food']);
        if (empty($foods)) {
            return new JsonResponse(null, Response::HTTP_BAD_REQUEST);
        }
        foreach ($foods as $food) {
            $takeAwayBooking->addFood($food);
        }
        $takeAwayBooking->setHourToRecover(new \DateTime($data['hourToRecover']));

        $takeAwayBooking->setCreatedAt(new \DateTimeImmutable());


        $this->manager->persist($takeAwayBooking);
        $this->manager->flush();

        $responseData = $this->serializer->serialize(
            $takeAwayBooking,
            'json',
            ['groups' => ['takeAwayBookings', 'category', 'food', 'user:read']]
        );

        $location = $this->urlGenerator->generate(
            'app_api_take_away_booking_show',
            ['id' => $takeAwayBooking->getId()],
            UrlGeneratorInterface::ABSOLUTE_URL
        );

        return new JsonResponse($responseData, Response::HTTP_CREATED, ['Location' => $location], true);
    }
    #[Route('/{id}', name: 'show', methods: 'GET')]
    #[OA\Get(
        path: "/api/takeawaybooking/{id}",
        summary: "Afficher une reservation à emporter par son id",
        parameters: [
            new OA\Parameter(
                name: "id",
                in: "path",
                required: true,
                schema: new OA\Schema(type: "integer")
            )
        ],
        responses: [
            new OA\Response(
                response: '200',
                description: 'Retourne une reservation à emporter',
                content: new OA\MediaType(
                    mediaType: 'application/json',
                    schema: new OA\Schema(
                        type: 'object',
                        properties: [
                            new OA\Property(
                                property: 'id',
                                type: 'integer',
                                example: 1
                            ),
                            new OA\Property(
                                property: 'food',
                                type: 'array',
                                items: new OA\Items(
                                    type: 'object',
                                    properties: [
                                        new OA\Property(
                                            property: 'title',
                                            type: 'string',
                                            example: 'Pizza'
                                        ),
                                        new OA\Property(
                                            property: 'description',
                                            type: 'string',
                                            example: 'Pizza au fromage'
                                        ),
                                        new OA\Property(
                                            property: 'price',
                                            type: 'float',
                                            example: 10.50
                                        ),
                                        new OA\Property(
                                            property: 'createdAt',
                                            type: 'string',
                                            format: 'date-time',
                                            example: '2023-01-01T00:00:00+00:00'
                                        ),
                                        new OA\Property(
                                            property: 'updatedAt',
                                            type: 'string',
                                            format: 'date-time',
                                        ),
                                        new OA\Property(
                                            property: 'category',
                                            type: 'object',
                                            properties: [
                                                new OA\Property(
                                                    property: 'id',
                                                    type: 'integer',
                                                    example: 1
                                                ),
                                                new OA\Property(
                                                    property: 'title',
                                                    type: 'string',
                                                    example: 'Entrée'
                                                ),
                                            ]
                                        )
                                    ]
                                )
                            ),
                            new OA\Property(
                                property: 'user',
                                type: 'object',
                                properties: [
                                    new OA\Property(
                                        property: 'firstName',
                                        type: 'string',
                                        example: 'John'
                                    ),
                                    new OA\Property(
                                        property: 'lastName',
                                        type: 'string',
                                        example: 'Doe'
                                    )
                                ]
                            ),
                            new OA\Property(
                                property: 'createdAt',
                                type: 'string',
                                format: 'date-time',
                                example: '2023-01-01T00:00:00+00:00'
                            ),
                            new OA\Property(
                                property: 'hourToRecoverString',
                                type: 'string',
                                example: '20:30'
                            )
                        ]
                    )
                )
            )

        ]
    )]
    public function show(int $id): JsonResponse
    {
        $takeAwayBooking = $this->repository->findOneBy(['id' => $id]);
        $takeAwayBooking = $this->serializer->serialize($takeAwayBooking, 'json', ['groups' => ['takeAwayBookings', 'category', 'food', 'user:read']]);
        return new JsonResponse($takeAwayBooking, Response::HTTP_OK, [], true);
    }
    #[Route('/{id}', name: 'edit', methods: 'PUT')]
    #[
        OA\Put(
            path: "/api/takeawaybooking/{id}",
            summary: "Modifier une reservation à emporter par son id",
            parameters: [
                new OA\Parameter(
                    name: "id",
                    in: "path",
                    required: true,
                    schema: new OA\Schema(type: "integer")
                )
            ],
            requestBody: new OA\RequestBody(
                required: true,
                description: "Les données de la reservation à emporter pour sa mise à jour",
                content: new OA\MediaType(
                    mediaType: "application/json",
                    schema: new OA\Schema(
                        type: "object",
                        required: ["food", "hourToRecover"],
                        properties: [
                            new OA\Property(
                                property: "food",
                                type: "array",
                                items: new OA\Items(
                                    type: "integer",
                                    example: [1, 2, 3]
                                )
                            ),
                            new OA\Property(
                                property: "hourToRecover",
                                type: "string",
                                example: "20:30"
                            )
                        ]
                    )
                )
            ),
            responses: [
                new OA\Response(
                    response: '200',
                    description: 'Mise à jour de la reservation à emporter',
                    content: new OA\MediaType(
                        mediaType: 'application/json',
                        schema: new OA\Schema(
                            type: 'object',
                            properties: [
                                new OA\Property(
                                    property: 'id',
                                    type: 'integer',
                                    example: 1
                                ),
                                new OA\Property(
                                    property: 'food',
                                    type: 'array',
                                    items: new OA\Items(
                                        type: 'object',
                                        properties: [
                                            new OA\Property(
                                                property: 'title',
                                                type: 'string',
                                                example: 'Entrée'
                                            ),
                                            new OA\Property(
                                                property: 'description',
                                                type: 'string',
                                                example: 'Une description'
                                            ),
                                            new OA\Property(
                                                property: 'price',
                                                type: 'float',
                                                example: 10.99
                                            ),
                                            new OA\Property(
                                                property: 'createdAt',
                                                type: 'string',
                                                format: 'date-time',
                                                example: '2023-01-01T00:00:00+00:00'
                                            ),
                                            new OA\Property(
                                                property: 'updatedAt',
                                                type: 'string',
                                                format: 'date-time',
                                                example: '2023-01-01T00:00:00+00:00'
                                            ),
                                            new OA\Property(
                                                property: 'category',
                                                type: 'object',
                                                properties: [
                                                    new OA\Property(
                                                        property: 'id',
                                                        type: 'integer',
                                                        example: 1
                                                    ),
                                                    new OA\Property(
                                                        property: 'title',
                                                        type: 'string',
                                                        example: 'Entrée'
                                                    ),
                                                ]
                                            )
                                        ]
                                    )
                                ),
                                new OA\Property(
                                    property: 'user',
                                    type: 'object',
                                    properties: [
                                        new OA\Property(
                                            property: 'firstName',
                                            type: 'string',
                                            example: 'John'
                                        ),
                                        new OA\Property(
                                            property: 'lastName',
                                            type: 'string',
                                            example: 'Doe'
                                        ),
                                    ]
                                ),
                                new OA\Property(
                                    property: 'createdAt',
                                    type: 'string',
                                    format: 'date-time',
                                    example: '2023-01-01T00:00:00+00:00'
                                ),
                                new OA\Property(
                                    property: 'hourToRecoverString',
                                    type: 'string',
                                    example: '20:30'
                                )
                            ]
                        )
                    )
                )
            ]
        )
    ]
    public function edit(int $id, Request $request): JsonResponse
    {
        $takeAwayBooking = $this->repository->findById($id);
        $data = json_decode($request->getContent(), true);

        foreach ($takeAwayBooking->getFood() as $food) {
            $takeAwayBooking->removeFood($food);
        }
        $foods = $this->manager->getRepository(Food::class)->findByIds($data['food']);
        foreach ($foods as $food) {
            $takeAwayBooking->addFood($food);
        }

        $takeAwayBooking->setHourToRecover(new \DateTime($data['hourToRecover']));

        $takeAwayBooking->setUpdatedAt(new \DateTimeImmutable());

        $this->manager->flush();

        $responseData = $this->serializer->serialize($takeAwayBooking, 'json', ['groups' => ['takeAwayBookings', 'category', 'food', 'user:read']]);
        $location = $this->urlGenerator->generate(
            'app_api_take_away_booking_show',
            ['id' => $takeAwayBooking->getId()],
            UrlGeneratorInterface::ABSOLUTE_URL
        );
        return new JsonResponse($responseData, Response::HTTP_OK, ['Location' => $location], true);
    }
    #[Route('/{id}', name: 'delete', methods: 'DELETE')]
    #[
        OA\Delete(
            path: '/api/takeawaybooking/{id}',
            summary: 'Supprimer une reservation à emporter par son id',
            parameters: [
                new OA\Parameter(
                    name: 'id',
                    in: 'path',
                    required: true,
                    schema: new OA\Schema(type: 'integer')
                )
            ],
            responses: [
                new OA\Response(
                    response: '204',
                    description: 'Reservation à emporter supprimée avec succès'
                )
            ]

        )
    ]
    public function delete(int $id): JsonResponse
    {
        $takeAwayBooking = $this->repository->findOneBy(['id' => $id]);
        $this->manager->remove($takeAwayBooking);
        $this->manager->flush();
        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }
}
