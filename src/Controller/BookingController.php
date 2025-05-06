<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Entity\User;
use App\Repository\BookingRepository;
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

#[Route('/api/booking', name: 'app_api_booking_')]
final class BookingController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $manager,
        private BookingRepository $repository,
        private SerializerInterface $serializer,
        private UrlGeneratorInterface $urlGenerator
    ) {}

    #[Route(name: 'new', methods: 'POST')]
    #[
        OA\Post(
            path: '/api/booking',
            summary: 'Créer une nouvelle commande',
            parameters: [
                new OA\Parameter(
                    name: 'Authorization',
                    in: 'header',
                    required: true,
                    schema: new OA\Schema(type: 'string')
                )
            ],
            requestBody: new OA\RequestBody(
                required: true,
                description: 'Informations de la commande',
                content: new OA\MediaType(
                    mediaType: 'application/json',
                    schema: new OA\Schema(
                        type: 'object',
                        required: ['guestNumber', 'orderDate', 'orderHour', 'guestAllergy'],
                        properties: [
                            new OA\Property(
                                property: 'guestNumber',
                                type: 'integer',
                                example: 2
                            ),
                            new OA\Property(
                                property: 'orderDate',
                                type: 'string',
                                format: 'date',
                                example: '2023-01-01'
                            ),
                            new OA\Property(
                                property: 'orderHour',
                                type: 'string',
                                format: 'time',
                                example: '12:00'
                            ),
                            new OA\Property(
                                property: 'guestAllergy',
                                type: 'string',
                                example: 'Gluten'
                            )
                        ]
                    )
                )
            ),
            responses: [
                new OA\Response(
                    response: '201',
                    description: 'Commande crée avec succès',
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
                                    property: 'guestNumber',
                                    type: 'integer',
                                    example: 2
                                ),
                                new OA\Property(
                                    property: 'guestAllergy',
                                    type: 'string',
                                    example: 'Gluten'
                                ),
                                new OA\Property(
                                    property: 'user',
                                    type: 'object',
                                    properties: [
                                        new OA\Property(
                                            property: 'id',
                                            type: 'integer',
                                            example: 1
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
                                                new OA\Property(
                                                    property: 'allergy',
                                                    type: 'string',
                                                    example: 'Gluten'
                                                )
                                            ]
                                        ),
                                        new OA\Property(
                                            property: 'allergy',
                                            type: 'string',
                                            example: 'Gluten'
                                        )
                                    ]
                                ),
                                new OA\Property(
                                    property: 'orderDateString',
                                    type: 'string',
                                    format: 'date',
                                    example: '2023-01-01'
                                ),
                                new OA\Property(
                                    property: 'orderHourString',
                                    type: 'string',
                                    format: 'time',
                                    example: '12:00'
                                )
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
        $booking = $this->serializer->deserialize($request->getContent(), Booking::class, 'json');

        $user = $security->getUser();
        $booking->addUser($user);
        $booking->setCreatedAt(new \DateTimeImmutable());

        $this->manager->persist($booking);
        $this->manager->flush();


        $responseData = $this->serializer->serialize(
            $booking,
            'json',
            ['groups' => ['bookings']]
        );

        $location = $this->urlGenerator->generate(
            'app_api_booking_show',
            ['id' => $booking->getId()],
            UrlGeneratorInterface::ABSOLUTE_URL
        );

        return new JsonResponse($responseData, Response::HTTP_CREATED, ['Location' => $location], true);
    }

    #[Route(name: 'index', methods: 'GET')]
    #[
        OA\Get(
            path: '/api/booking',
            summary: 'Voir la liste des commandes',
            responses: [
                new OA\Response(
                    response: '200',
                    description: 'Liste des commandes',
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
                                        property: 'guestNumber',
                                        type: 'integer',
                                        example: 2
                                    ),
                                    new OA\Property(
                                        property: 'guestAllergy',
                                        type: 'string',
                                        example: 'Gluten'
                                    ),
                                    new OA\Property(
                                        property: 'user',
                                        type: 'object',
                                        properties: [
                                            new OA\Property(
                                                property: 'id',
                                                type: 'integer',
                                                example: 1
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
                                                    new OA\Property(
                                                        property: 'allergy',
                                                        type: 'string',
                                                        example: 'Gluten'
                                                    ),
                                                ]
                                            )
                                        ]
                                    ),
                                    new OA\Property(
                                        property: 'orderDateString',
                                        type: 'string',
                                        format: 'date',
                                        example: '2023-01-01'
                                    ),
                                    new OA\Property(
                                        property: 'orderHourString',
                                        type: 'string',
                                        format: 'time',
                                        example: '12:00'
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
        $booking = $this->manager->getRepository(Booking::class)->findAll();
        $booking = $this->serializer->serialize($booking, 'json', ['groups' => ['bookings']]);
        return new JsonResponse($booking, Response::HTTP_OK, [], true);
    }

    #[Route('/{id}', name: 'show', methods: 'GET')]
    #[
        OA\Get(
            path: '/api/booking/{id}',
            summary: 'Voir une commande par son id',
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
                    response: '200',
                    description: 'Commande trouvée avec succès',
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
                                    property: 'guestNumber',
                                    type: 'integer',
                                    example: 2
                                ),
                                new OA\Property(
                                    property: 'guestAllergy',
                                    type: 'string',
                                    example: 'Gluten'
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
                                        new OA\Property(
                                            property: 'allergy',
                                            type: 'string',
                                            example: 'Gluten'
                                        ),
                                    ]
                                ),
                                new OA\Property(
                                    property: 'orderDateString',
                                    type: 'string',
                                    format: 'date',
                                    example: '2023-01-01'
                                ),
                                new OA\Property(
                                    property: 'orderHourString',
                                    type: 'string',
                                    format: 'time',
                                    example: '12:00'
                                )
                            ]
                        )
                    )
                )
            ]
        )
    ]
    public function show(int $id): JsonResponse
    {
        $booking = $this->repository->findOneBy(['id' => $id]);
        $responseData = $this->serializer->serialize($booking, 'json', ['groups' => ['bookings']]);
        return new JsonResponse($responseData, Response::HTTP_OK, [], true);
    }
    #[Route('/{id}', name: 'edit', methods: 'PUT')]
    #[
        OA\Put(
            path: '/api/booking/{id}',
            summary: 'Modifier une commande par son id',
            parameters: [
                new OA\Parameter(
                    name: 'id',
                    in: 'path',
                    required: true,
                    schema: new OA\Schema(type: 'integer')
                )
            ],
            requestBody: new OA\RequestBody(
                required: true,
                description: 'Les données de la commande pour sa mise à jour',
                content: new OA\MediaType(
                    mediaType: 'application/json',
                    schema: new OA\Schema(
                        type: 'object',
                        required: ['guestNumber', 'orderDate', 'orderHour', 'guestAllergy'],
                        properties: [
                            new OA\Property(
                                property: 'guestNumber',
                                type: 'integer',
                                example: 2
                            ),
                            new OA\Property(
                                property: 'orderDate',
                                type: 'string',
                                format: 'date',
                                example: '2023-01-01'
                            ),
                            new OA\Property(
                                property: 'orderHour',
                                type: 'string',
                                format: 'time',
                                example: '12:00'
                            ),
                            new OA\Property(
                                property: 'guestAllergy',
                                type: 'string',
                                example: 'Gluten'
                            )
                        ]
                    )
                )
            ),
            responses: [
                new OA\Response(
                    response: '200',
                    description: 'Commande mise à jour avec succès',
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
                                    property: 'guestNumber',
                                    type: 'integer',
                                    example: 2
                                ),
                                new OA\Property(
                                    property: 'guestAllergy',
                                    type: 'string',
                                    example: 'Gluten'
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
                                        new OA\Property(
                                            property: 'allergy',
                                            type: 'string',
                                            example: 'Gluten'
                                        ),
                                    ]
                                ),
                                new OA\Property(
                                    property: 'orderDateString',
                                    type: 'string',
                                    format: 'date',
                                    example: '2023-01-01'
                                ),
                                new OA\Property(
                                    property: 'orderHourString',
                                    type: 'string',
                                    format: 'time',
                                    example: '12:00'
                                )
                            ]
                        )
                    )
                ),
            ]
        )
    ]
    public function edit(int $id, Request $request): JsonResponse
    {
        $booking = $this->repository->findOneBy(['id' => $id]);

        $data = json_decode($request->getContent(), true);

        if ($data['guestNumber']) {
            $booking->setGuestNumber($data['guestNumber']);
        }

        if ($data['orderDate']) {
            $booking->setOrderDate(new \DateTimeImmutable($data['orderDate']));
        }

        if ($data['orderHour']) {
            $booking->setOrderHour(new \DateTimeImmutable($data['orderHour']));
        }

        if ($data['guestAllergy']) {
            $booking->setGuestAllergy($data['guestAllergy']);
        }

        $booking->setUpdatedAt(new \DateTimeImmutable());

        $this->manager->flush();

        $responseData = $this->serializer->serialize(
            $booking,
            'json',
            ['groups' => ['bookings']]
        );
        $location = $this->urlGenerator->generate(
            'app_api_booking_show',
            ['id' => $booking->getId()],
            UrlGeneratorInterface::ABSOLUTE_URL
        );
        return new JsonResponse($responseData, Response::HTTP_OK, ['location' => $location], true);
    }
    #[Route('/{id}', name: 'delete', methods: 'DELETE')]
    #[
        OA\Delete(
            path: '/api/booking/{id}',
            summary: 'Supprimer une reservation par son id',
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
                    response: '200',
                    description: 'Reservation supprimée avec succès',
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
                                    example: 'La réservation a été supprimée avec succès'
                                )
                            ]
                        )
                    )
                )
            ]
        )
    ]
    public function delete(int $id): JsonResponse
    {
        $booking = $this->repository->findOneBy(['id' => $id]);
        if ($booking) {
            $this->manager->remove($booking);
            $this->manager->flush();
            return new JsonResponse(['status' => 'succès', 'message' => 'La réservation a été supprimée avec succès'], Response::HTTP_OK);
        }
        return new JsonResponse(null, Response::HTTP_NOT_FOUND);
    }
}
