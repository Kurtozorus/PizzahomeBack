<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/category', name: 'app_api_category_')]
final class CategoryController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $manager,
        private CategoryRepository $repository,
        private SerializerInterface $serializer,
        private UrlGeneratorInterface $urlGenerator
    ) {}
    #[Route(name: 'new', methods: 'POST')]
    #[
        OA\Post(
            path: "/api/category",
            summary: "Ajouter une categorie",
            requestBody: new OA\RequestBody(
                required: true,
                description: "Les données de la categorie pour sa création",
                content: new OA\MediaType(
                    mediaType: "application/json",
                    schema: new OA\Schema(
                        type: "object",
                        required: ["title"],
                        properties: [
                            new OA\Property(
                                property: "title",
                                type: "string",
                                example: "entrée"
                            )
                        ]
                    )
                )
            ),
            responses: [
                new OA\Response(
                    response: '201',
                    description: 'Categorie crée avec succès',
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
                                    property: 'title',
                                    type: 'string',
                                    example: 'entrée'
                                ),
                                new OA\Property(
                                    property: 'created_at',
                                    type: 'string',
                                    example: '2023-01-01T00:00:00+00:00'
                                ),
                                new OA\Property(
                                    property: 'updated_at',
                                    type: 'string',
                                    example: '2023-01-01T00:00:00+00:00'
                                ),
                                new OA\Property(
                                    property: 'food',
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
                                            example: 'Pizza'
                                        ),
                                    ]
                                )
                            ]
                        )
                    )
                )
            ]
        )
    ]
    public function new(Request $request): JsonResponse
    {
        $category = $this->serializer->deserialize($request->getContent(), Category::class, 'json');
        $category->setCreatedAt(new \DateTimeImmutable());

        $this->manager->persist($category);
        $this->manager->flush();

        $responseData = $this->serializer->serialize($category, 'json');
        $location = $this->urlGenerator->generate(
            'app_api_category_show',
            ['id' => $category->getId()],
            UrlGeneratorInterface::ABSOLUTE_URL
        );
        return new JsonResponse($responseData, Response::HTTP_CREATED, ['Location' => $location], true);
    }

    #[Route(name: 'index', methods: 'GET')]
    #[
        OA\Get(
            path: '/api/category',
            summary: 'Voir la liste des catégories',
            responses: [
                new OA\Response(
                    response: '200',
                    description: 'Liste des categories',
                    content: new OA\MediaType(
                        mediaType: 'application/json',
                        schema: new OA\Schema(
                            type: 'object',
                            properties: [
                                new OA\Property(
                                    property: "categories",
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
                                        ),
                                        new OA\Property(
                                            property: "created_at",
                                            type: "string",
                                            example: "2023-01-01T00:00:00+00:00"
                                        ),
                                        new OA\Property(
                                            property: "updated_at",
                                            type: "string",
                                            example: "2023-01-01T00:00:00+00:00"
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
    public function index(): JsonResponse
    {
        $category = $this->manager->getRepository(Category::class)->findAll();
        $categoryList = array_map(function (Category $category) {
            return [
                'id' => $category->getId(),
                'title' => $category->getTitle()
            ];
        }, $category);
        return new JsonResponse(
            ['categories' => $categoryList],
            Response::HTTP_OK
        );
    }

    #[Route('/{id}', name: 'show', methods: 'GET')]
    #[OA\Get(
        path: "/api/category/{id}",
        summary: "Voir une categorie par son id",
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
                description: 'Categorie trouvée avec succès',
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
                                property: 'title',
                                type: 'string',
                                example: 'entrée'
                            ),
                            new OA\Property(
                                property: 'created_at',
                                type: 'string',
                                example: '2023-01-01T00:00:00+00:00'
                            ),
                            new OA\Property(
                                property: 'updated_at',
                                type: 'string',
                                example: '2023-01-01T00:00:00+00:00'
                            ),
                            new OA\Property(
                                property: 'food',
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
                                        example: 'Pizza'
                                    ),
                                ]
                            )
                        ]
                    )
                )
            )
        ]
    )]
    public function show(int $id): JsonResponse
    {
        $category = $this->repository->findOneBy(["id" => $id]);
        $responseData = $this->serializer->serialize($category, 'json');
        return new JsonResponse($responseData, Response::HTTP_OK, [], true);
    }


    #[Route('/{id}', name: 'edit', methods: 'PUT')]
    #[OA\Put(
        path: "/api/category/{id}",
        summary: "Modifier une categorie par son id",
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
            description: "Les données de la categorie pour sa mise à jour",
            content: new OA\MediaType(
                mediaType: "application/json",
                schema: new OA\Schema(
                    type: "object",
                    required: ["title"],
                    properties: [
                        new OA\Property(
                            property: "title",
                            type: "string",
                            example: "entrée"
                        )
                    ]
                )
            )
        ),
        responses: [
            new OA\Response(
                response: '200',
                description: 'Categorie modifiée avec succès',
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
                                property: 'title',
                                type: 'string',
                                example: 'entrée'
                            ),
                        ]
                    )
                )
            ),
            new OA\Response(
                response: '404',
                description: 'Categorie non trouvée'
            )
        ]
    )]
    public function edit(int $id, Request $request): JsonResponse
    {
        $category = $this->repository->findOneBy(['id' => $id]);
        if ($category) {
            $category = $this->serializer->deserialize(
                $request->getContent(),
                Category::class,
                'json',
                [AbstractNormalizer::OBJECT_TO_POPULATE => $category]
            );
            $category->setUpdatedAt(new \DateTimeImmutable());

            $this->manager->flush();

            $responseData = $this->serializer->serialize($category, 'json');
            $location = $this->urlGenerator->generate(
                'app_api_category_show',
                ['id' => $category->getId()],
                UrlGeneratorInterface::ABSOLUTE_URL
            );
            return new JsonResponse($responseData, Response::HTTP_OK, ['Location' => $location], true);
        }
        return new JsonResponse(null, Response::HTTP_NOT_FOUND);
    }

    #[Route('/{id}', name: 'delete', methods: 'DELETE')]
    #[OA\Delete(
        path: "/api/category/{id}",
        summary: "Supprimer une categorie par son id",
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
                description: 'Categorie supprimée avec succès',
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
                                example: 'La categorie a été supprimée avec succès'
                            )
                        ]
                    )
                )
            )
        ]
    )]
    public function delete(int $id): JsonResponse
    {
        $category = $this->manager->getRepository(Category::class)->find($id);
        if ($category) {
            $this->manager->remove($category);
            $this->manager->flush();
            return new JsonResponse(['status' => 'succès', 'message' => 'La categorie a été supprimée avec succès'], Response::HTTP_OK);
        }
        return new JsonResponse(null, Response::HTTP_NOT_FOUND);
    }
}
