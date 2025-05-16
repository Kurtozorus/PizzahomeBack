<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Food;
use App\Entity\User;
use App\Repository\FoodRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use OpenApi\Attributes as OA;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/food', name: 'app_api_food_')]
final class FoodController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $manager,
        private FoodRepository $repository,
        private SerializerInterface $serializer,
        private UrlGeneratorInterface $urlGenerator,
    ) {}

    #[Route(name: 'new', methods: 'POST')]
    #[
        OA\Post(
            path: "/api/food",
            summary: "Ajouter un plat",
            requestBody: new OA\RequestBody(
                required: true,
                description: "Les données du plat pour sa création",
                content: new OA\MediaType(
                    mediaType: "application/json",
                    schema: new OA\Schema(
                        type: "object",
                        required: ["title", "description", "price", "category"],
                        properties: [
                            new OA\Property(
                                property: "title",
                                type: "string",
                                example: "Portion de frite"
                            ),
                            new OA\Property(
                                property: "description",
                                type: "string",
                                example: "Assiette de frites"
                            ),
                            new OA\Property(
                                property: "price",
                                type: "float",
                                example: 2.50
                            ),
                            new OA\Property(
                                property: "category",
                                type: "integer",
                                example: 1
                            )
                        ]
                    )
                )
            ),
            responses: [
                new OA\Response(
                    response: "201",
                    description: "Plat ajouté avec succès",
                    content: new OA\MediaType(
                        mediaType: "application/json",
                        schema: new OA\Schema(
                            type: "object",
                            properties: [
                                new OA\Property(
                                    property: "title",
                                    type: "string",
                                    example: "portion de frite"
                                ),
                                new OA\Property(
                                    property: "description",
                                    type: "string",
                                    example: "Assiette de frites"
                                ),
                                new OA\Property(
                                    property: "price",
                                    type: "float",
                                    example: 2.50
                                ),
                                new OA\Property(
                                    property: "category",
                                    type: "object",
                                    properties: [
                                        new OA\Property(
                                            property: "id",
                                            type: "integer",
                                            example: 1
                                        ),
                                        new OA\Property(
                                            property: "title",
                                            type: "string",
                                            example: "entrée"
                                        )
                                    ]
                                ),
                            ]
                        )
                    )
                ),
                new OA\Response(
                    response: "401",
                    description: "Requête non autorisée"
                )
            ]
        )
    ]
    public function new(Request $request, Security $security): JsonResponse
    {
        $user = $security->getUser();

        if (!$user instanceof User) {
            return new JsonResponse(
                ['message' => 'Accès non autorisé'],
                Response::HTTP_UNAUTHORIZED
            );
        }

        if (
            !in_array('ROLE_ADMIN', $user->getRoles())
            && !in_array('ROLE_RESPONSABLE', $user->getRoles())
        ) {
            return new JsonResponse(
                ['message' => 'Accès non autorisé'],
                Response::HTTP_UNAUTHORIZED
            );
        }
        /** @var Category $category */
        $data = json_decode($request->getContent(), true);
        $food = new Food();
        $food->setTitle($data['title']);
        $food->setDescription($data['description']);
        $food->setPrice($data['price']);
        $food->setCreatedAt(new \DateTimeImmutable());

        if ($data['category']) {
            $category = $this->manager->getRepository(Category::class)->find($data['category']);
            if ($category) {
                $food->setCategory($category);
            } else {
                return new JsonResponse(['error' => 'Categorie introuvable'], Response::HTTP_NOT_FOUND);
            }
        }

        $this->manager->persist($food);
        $this->manager->flush();

        $responseData = $this->serializer->serialize(
            $food,
            'json',
            ['groups' => ["food"]]
        );
        $location = $this->urlGenerator->generate(
            'app_api_food_show',
            ['id' => $food->getId()],
            UrlGeneratorInterface::ABSOLUTE_URL
        );
        return new JsonResponse($responseData, Response::HTTP_CREATED, ['Location' => $location], true);
    }

    #[Route('/', name: 'index', methods: 'GET')]
    #[
        OA\Get(
            path: '/api/food/',
            summary: 'Lister tous les plats',
            responses: [
                new OA\Response(
                    response: '200',
                    description: 'Liste des plats',
                    content: new OA\MediaType(
                        mediaType: 'application/json',
                        schema: new OA\Schema(
                            type: 'object',
                            properties: [
                                new OA\Property(
                                    property: 'foods',
                                    type: 'array',
                                    items: new OA\Items(
                                        properties: [
                                            new OA\Property(
                                                property: 'id',
                                                type: 'integer',
                                                example: 1
                                            ),
                                            new OA\Property(
                                                property: 'title',
                                                type: 'string',
                                                example: 'Pizza'
                                            ),
                                            new OA\Property(
                                                property: 'description',
                                                type: 'string',
                                                example: 'Description de la pizza'
                                            ),
                                            new OA\Property(
                                                property: 'price',
                                                type: 'number',
                                                example: 12.99
                                            ),
                                        ]
                                    )
                                )
                            ]
                        )
                    )
                )
            ]
        )
    ]
    public function index(): JsonResponse
    {
        $food = $this->manager->getRepository(Food::class)->findAll();
        $foodList = array_map(function (Food $food) {
            return [
                'id' => $food->getId(),
                'title' => $food->getTitle(),
                'description' => $food->getDescription(),
                'price' => $food->getPrice(),
            ];
        }, $food);
        return new JsonResponse(
            ['foods' => $foodList],
            JsonResponse::HTTP_OK
        );
    }

    #[Route('/{id}', name: 'show', methods: 'GET')]
    #[
        OA\Get(
            path: "/api/food/{id}",
            summary: "Voir un plat par son id",
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
                    response: "200",
                    description: "Plat trouvé",
                    content: new OA\MediaType(
                        mediaType: "application/json",
                        schema: new OA\Schema(
                            type: "object",
                            properties: [
                                new OA\Property(
                                    property: "title",
                                    type: "string",
                                    example: "portion de frite"
                                ),
                                new OA\Property(
                                    property: "description",
                                    type: "string",
                                    example: "Assiette de frites"
                                ),
                                new OA\Property(
                                    property: "price",
                                    type: "float",
                                    example: 2.50
                                ),
                                new OA\Property(
                                    property: "createdAt",
                                    type: "string",
                                    example: "2023-01-01T00:00:00+00:00"
                                ),
                                new OA\Property(
                                    property: "updatedAt",
                                    type: "string",
                                    example: null
                                ),
                                new OA\Property(
                                    property: "category",
                                    type: "object",
                                    properties: [
                                        new OA\Property(
                                            property: "id",
                                            type: "integer",
                                            example: 1
                                        ),
                                        new OA\Property(
                                            property: "title",
                                            type: "string",
                                            example: "entrée"
                                        )
                                    ]
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
        $food = $this->repository->findOneBy(['id' => $id]);
        $responseData = $this->serializer->serialize($food, 'json', ['groups' => ["food"]]);
        return new JsonResponse($responseData, Response::HTTP_OK, [], true);
    }

    #[Route('/{id}', name: 'edit', methods: 'PUT')]
    #[
        OA\Put(
            path: "/api/food/{id}",
            summary: "Modifier un plat par son id",
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
                description: "Les données du plat pour sa mise à jour",
                content: new OA\MediaType(
                    mediaType: "application/json",
                    schema: new OA\Schema(
                        type: "object",
                        required: ["title", "description", "price", "category"],
                        properties: [
                            new OA\Property(
                                property: "title",
                                type: "string",
                                example: "portion de frite"
                            ),
                            new OA\Property(
                                property: "description",
                                type: "string",
                                example: "Assiette de frites"
                            ),
                            new OA\Property(
                                property: "price",
                                type: "float",
                                example: 2.50
                            ),
                            new OA\Property(
                                property: "category",
                                type: "integer",
                                example: 1
                            )
                        ]
                    )
                )
            ),
            responses: [
                new OA\Response(
                    response: "200",
                    description: "Plat mis à jour",
                    content: new OA\MediaType(
                        mediaType: "application/json",
                        schema: new OA\Schema(
                            type: "object",
                            properties: [
                                new OA\Property(
                                    property: "title",
                                    type: "string",
                                    example: "portion de frite"
                                ),
                                new OA\Property(
                                    property: "description",
                                    type: "string",
                                    example: "Assiette de frites"
                                ),
                                new OA\Property(
                                    property: "price",
                                    type: "float",
                                    example: 2.50
                                ),
                                new OA\Property(
                                    property: "createdAt",
                                    type: "string",
                                    example: "2023-01-01T00:00:00+00:00"
                                ),
                                new OA\Property(
                                    property: "updatedAt",
                                    type: "string",
                                    example: "2023-01-01T00:00:00+00:00"
                                )

                            ]
                        )
                    )
                ),
                new OA\Response(
                    response: "404",
                    description: "Plat introuvable",
                    content: new OA\MediaType(
                        mediaType: "application/json",
                        schema: new OA\Schema(
                            type: "object",
                            properties: [
                                new OA\Property(
                                    property: "error",
                                    type: "string",
                                    example: "Categorie introuvable"
                                )
                            ]
                        )
                    )
                ),
                new OA\Response(
                    response: "401",
                    description: "Requête non autorisé",
                )
            ]
        )
    ]
    public function edit(int $id, Request $request, Security $security): JsonResponse
    {
        $user = $security->getUser();

        if (!$user instanceof User) {
            return new JsonResponse(
                ['message' => 'Accès non autorisé'],
                Response::HTTP_UNAUTHORIZED
            );
        }

        if (
            !in_array('ROLE_ADMIN', $user->getRoles())
            && !in_array('ROLE_RESPONSABLE', $user->getRoles())
        ) {
            return new JsonResponse(
                ['message' => 'Accès non autorisé'],
                Response::HTTP_UNAUTHORIZED
            );
        }
        $food = $this->repository->findOneBy(['id' => $id]);

        /** @var Category $category */
        $data = json_decode($request->getContent(), true);
        $food->setTitle($data['title']);
        $food->setDescription($data['description']);
        $food->setPrice($data['price']);
        $food->setUpdatedAt(new \DateTimeImmutable());

        if ($data['category']) {
            $category = $this->manager->getRepository(Category::class)->find($data['category']);
            if ($category) {
                $food->setCategory($category);
            } else {
                return new JsonResponse(['error' => 'Categorie introuvable'], Response::HTTP_NOT_FOUND);
            }
        }

        $this->manager->flush();

        $responseData = $this->serializer->serialize($food, 'json', ['groups' => ["food"]]);
        $location = $this->urlGenerator->generate(
            'app_api_food_show',
            ['id' => $food->getId()],
            UrlGeneratorInterface::ABSOLUTE_URL
        );
        return new JsonResponse($responseData, Response::HTTP_OK, ['Location' => $location], true);
    }

    #[Route('/{id}', name: 'delete', methods: 'DELETE')]
    #[
        OA\Delete(
            path: '/api/food/{id}',
            summary: 'Supprimer un plat par son id',
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
                    description: 'Plat supprimé avec succès',
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
                                    example: 'Le plat a été supprimé avec succès'
                                )
                            ]
                        )
                    )
                ),
                new OA\Response(
                    response: '404',
                    description: 'Plat introuvable',
                ),
                new OA\Response(
                    response: '401',
                    description: 'Requête non autorisé',
                )
            ]

        )
    ]
    public function delete(int $id, Security $security): JsonResponse
    {
        $user = $security->getUser();

        if (!$user instanceof User) {
            return new JsonResponse(
                ['message' => 'Accès non autorisé'],
                Response::HTTP_UNAUTHORIZED
            );
        }

        if (
            !in_array('ROLE_ADMIN', $user->getRoles())
            && !in_array('ROLE_RESPONSABLE', $user->getRoles())
        ) {
            return new JsonResponse(
                ['message' => 'Accès non autorisé'],
                Response::HTTP_UNAUTHORIZED
            );
        }
        $food = $this->repository->findOneBy(['id' => $id]);
        if ($food) {
            $this->manager->remove($food);
            $this->manager->flush();
            return new JsonResponse(['status' => 'succès', 'message' => 'Le plat a été supprimé avec succès'], Response::HTTP_OK);
        }
        return new JsonResponse(null, Response::HTTP_NOT_FOUND);
    }
}
