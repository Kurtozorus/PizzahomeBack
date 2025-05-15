<?php

namespace App\Controller;

use App\Entity\User;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Nelmio\ApiDocBundle\Attribute\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use OpenApi\Attributes as OA;
use Soap\Sdl;
use Symfony\Component\HttpFoundation\{JsonResponse, Request, Response};
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api', name: 'app_api_')]
final class SecurityController extends AbstractController
{
    public function __construct(
        private SerializerInterface $serializer,
        private EntityManagerInterface $manager,
        private UserPasswordHasherInterface $passwordHasher
    ) {}
    #[Route('/registration', name: 'registration', methods: ['POST'])]
    #[
        OA\Post(
            path: "/api/registration",
            summary: "Enregistrement d'un utilisateur",
            requestBody: new OA\RequestBody(
                required: true,
                description: "Les données de l'utilisateur pour son enregistrement",
                content: new OA\MediaType(
                    mediaType: "application/json",
                    schema: new OA\Schema(
                        type: "object",
                        required: ["email", "password", "firstName", "lastName"],
                        properties: [
                            new OA\Property(
                                property: "email",
                                type: "string",
                                format: "email",
                                example: "z2SdX@example.com"
                            ),
                            new OA\Property(
                                property: "password",
                                type: "string",
                                format: "password",
                                example: "mot de passe"
                            ),
                            new OA\Property(
                                property: "firstName",
                                type: "string",
                                example: "John"
                            ),
                            new OA\Property(
                                property: "lastName",
                                type: "string",
                                example: "Doe"
                            ),
                        ]
                    )
                )
            ),
            responses: [
                new OA\Response(
                    response: "201",
                    description: "Utilisateur enregistré avec succès",
                    content: new OA\MediaType(
                        mediaType: "application/json",
                        schema: new OA\Schema(
                            type: "object",
                            properties: [
                                new OA\Property(
                                    property: "user",
                                    type: "string",
                                    example: "z2SdX@example.com"
                                ),
                                new OA\Property(
                                    property: "apiToken",
                                    type: "string",
                                    example: "4af66451541d403167a1371f982921f7651f0ea5"
                                ),
                                new OA\Property(
                                    property: "roles",
                                    type: "array",
                                    items: new OA\Items(
                                        type: "string",
                                        example: "ROLE_USER"
                                    )
                                )
                            ]
                        )
                    )
                )
            ]
        )
    ]
    public function register(Request $request): JsonResponse
    {
        $user = $this->serializer->deserialize($request->getContent(), User::class, 'json');
        $user->setPassword($this->passwordHasher->hashPassword($user, $user->getPassword()));
        $user->setCreatedAt(new \DateTimeImmutable());

        $this->manager->persist($user);
        $this->manager->flush();
        return new JsonResponse(
            [
                'user' => $user->getUserIdentifier(),
                'apiToken' => $user->getApiToken(),
                'roles' => $user->getRoles()
            ],
            Response::HTTP_CREATED
        );
    }

    #[Route('/login', name: 'login', methods: ['POST'])]
    #[
        OA\Post(
            path: "/api/login",
            summary: "Connexion d'un utilisateur",
            requestBody: new OA\RequestBody(
                required: true,
                description: "Les données de l'utilisateur pour la connexion",
                content: new OA\MediaType(
                    mediaType: "application/json",
                    schema: new OA\Schema(
                        type: "object",
                        required: ["username", "password"],
                        properties: [
                            new OA\Property(
                                property: "username",
                                type: "string",
                                format: "email",
                                example: "z2SdX@example.com"
                            ),
                            new OA\Property(
                                property: "password",
                                type: "string",
                                format: "password",
                                example: "password"
                            ),
                        ]
                    )
                )
            ),
            responses: [
                new OA\Response(
                    response: "200",
                    description: "Utilisateur connecté avec succès",
                    content: new OA\MediaType(
                        mediaType: "application/json",
                        schema: new OA\Schema(
                            type: "object",
                            properties: [
                                new OA\Property(
                                    property: "user",
                                    type: "string",
                                    example: "z2SdX@example.com"
                                ),
                                new OA\Property(
                                    property: "apiToken",
                                    type: "string",
                                    example: "4af66451541d403167a1371f982921f7651f0ea5"
                                ),
                                new OA\Property(
                                    property: "roles",
                                    type: "array",
                                    items: new OA\Items(
                                        type: "string",
                                        example: "ROLE_USER"
                                    )
                                )
                            ]
                        )
                    )
                )
            ]
        )
    ]
    public function login(#[CurrentUser] ?User $user): JsonResponse
    {
        if (null === $user) {
            return $this->json([
                'message' => 'Données utilisateur introuvables',
            ], Response::HTTP_UNAUTHORIZED);
        }
        return new JsonResponse(
            [
                'user' => $user->getUserIdentifier(),
                'apiToken' => $user->getApiToken(),
                'roles' => $user->getRoles()
            ]
        );
    }
    #[Route('/account/me', name: 'me', methods: ['GET'])]
    #[
        OA\Get(
            path: "/api/account/me",
            summary: "Rendu du compte de l'utilisateur",
            responses: [
                new OA\Response(
                    response: "200",
                    description: "Renvoi les données du compte utilisateur",
                    content: new OA\MediaType(
                        mediaType: "application/json",
                        schema: new OA\Schema(
                            type: "object",
                            properties: [
                                new OA\Property(
                                    property: "email",
                                    type: "string",
                                    example: "z2SdX@example.com"
                                ),
                                new OA\Property(
                                    property: "roles",
                                    type: "array",
                                    items: new OA\Items(
                                        type: "string",
                                        example: "ROLE_USER"
                                    )
                                ),
                                new OA\Property(
                                    property: "firstName",
                                    type: "string",
                                    example: "John"
                                ),
                                new OA\Property(
                                    property: "lastName",
                                    type: "string",
                                    example: "Doe"
                                ),
                                new OA\Property(
                                    property: "allergy",
                                    type: "string",
                                    example: "Gluten"
                                ),
                                new OA\Property(
                                    property: "createdAt",
                                    type: "string",
                                    format: "date-time",
                                    example: "2023-05-12T10:15:30+00:00"
                                ),
                                new OA\Property(
                                    property: "updatedAt",
                                    type: "string",
                                    format: "date-time",
                                    example: "2023-05-12T10:15:30+00:00"
                                ),
                                new OA\Property(
                                    property: "apiToken",
                                    type: "string",
                                    example: "4af66451541d403167a1371f982921f7651f0ea5"
                                ),
                                new OA\Property(
                                    property: "Restaurant",
                                    type: "array",
                                    items: new OA\Items(
                                        type: "string",
                                        example: ["1", "2"]
                                    )
                                ),
                            ]
                        )
                    )
                )
            ]
        )
    ]
    public function me(#[CurrentUser] ?User $user): JsonResponse
    {
        $user = $this->serializer->serialize($user, 'json', ['groups' => ['userInfo']]);
        return new JsonResponse($user, Response::HTTP_OK, [], true);
    }

    #[Route('/account/edit', name: 'edit', methods: ['PUT'])]
    #[
        OA\Put(
            path: "/api/account/edit",
            summary: "Edition / modification du compte d'un utilisateur",
            requestBody: new OA\RequestBody(
                required: true,
                description: "Donnée de l'utilisateur à modifier",
                content: new OA\MediaType(
                    mediaType: "application/json",
                    schema: new OA\Schema(
                        type: "object",
                        required: ["password", "firstName", "lastName", "allergy"],
                        properties: [
                            new OA\Property(
                                property: "password",
                                type: "string",
                                format: "password",
                                example: "password"
                            ),
                            new OA\Property(
                                property: "firstName",
                                type: "string",
                                example: "Brice"
                            ),
                            new OA\Property(
                                property: "lastName",
                                type: "string",
                                example: "Dos"
                            ),
                            new OA\Property(
                                property: "allergy",
                                type: "string",
                                example: "Lactose"
                            )
                        ]
                    )
                )
            ),
            responses: [
                new OA\Response(
                    response: "200",
                    description: "Prise en compte de la modification enregistré avec succès",
                    content: new OA\MediaType(
                        mediaType: "application/json",
                        schema: new OA\Schema(
                            type: "object",
                            properties: [
                                new OA\Property(
                                    property: "firstName",
                                    type: "string",
                                    example: "Brice"
                                ),
                                new OA\Property(
                                    property: "lastName",
                                    type: "string",
                                    example: "Dos"
                                ),
                                new OA\Property(
                                    property: "allergy",
                                    type: "string",
                                    example: 'Lactose'
                                )
                            ]
                        )
                    )
                )
            ]
        )
    ]
    public function edit(Request $request): JsonResponse
    {
        $user = $this->serializer->deserialize(
            $request->getContent(),
            User::class,
            'json',
            [AbstractNormalizer::OBJECT_TO_POPULATE => $this->getUser()],
        );
        $user->setPassword($this->passwordHasher->hashPassword($user, $user->getPassword()));
        $user->setUpdatedAt(new \DateTimeImmutable());

        $this->manager->flush();

        $responseData = $this->serializer->serialize($user, 'json', [
            AbstractNormalizer::ATTRIBUTES => [
                'firstName',
                'lastName',
                'allergy',
            ],
        ]);
        return new JsonResponse($responseData, Response::HTTP_OK, [], true);
    }


    #[Route('/account/delete', name: 'delete', methods: 'DELETE')]
    // #[
    //     OA\Delete(
    //         path: "/api/account/delete",
    //         summary: "Suppression du compte d'un utilisateur",
    //         Responses: [
    //             new OA\Response(
    //                 response: "204",
    //                 description: "Compte supprimé avec succès"
    //             )
    //         ]
    //     )
    // ]
    #[
        OA\Delete(
            path: "/api/account/delete",
            summary: "Suppression du compte d'un utilisateur",
            responses: [
                new OA\Response(
                    response: "204",
                    description: "Compte supprimé avec succès",
                    content: new OA\MediaType(
                        mediaType: "application/json",
                        schema: new OA\Schema(
                            type: "object",
                        )
                    )
                )
            ]
        )
    ]
    public function delete(): JsonResponse
    {
        $user = $this->getUser();
        $this->manager->remove($user);
        $this->manager->flush();
        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }


    #[Route(
        '/admin/create-responsable',
        name: 'admin_create_responsable',
        methods: 'POST'
    )]
    #[OA\Post(
        path: "/api/admin/create-responsable",
        summary: "Créer un responsable par administrateur",
        requestBody: new OA\RequestBody(
            required: true,
            description: "Données de l'utilisateur à créer",
            content: new OA\MediaType(
                mediaType: "application/json",
                schema: new OA\Schema(
                    type: "object",
                    required: ["email", "password", 'firstName', 'lastName'],
                    properties: [
                        new OA\Property(
                            property: "email",
                            type: "string",
                            example: "employe@example.com"
                        ),
                        new OA\Property(
                            property: "password",
                            type: "string",
                            format: "password",
                            example: "Azerty$1"
                        ),
                        new OA\Property(
                            property: "firstName",
                            type: "string",
                            example: "Bruno"
                        ),
                        new OA\Property(
                            property: "lastName",
                            type: "string",
                            example: "Bala"
                        )
                    ]
                )
            )
        ),
        responses: [
            new OA\Response(
                response: 201,
                description: "Responsable créé avec succès",
                content: new OA\MediaType(
                    mediaType: "application/json",
                    schema: new OA\Schema(
                        type: "object",
                        properties: [
                            new OA\Property(
                                property: "id",
                                type: "integer",
                                example: 1
                            ),
                            new OA\Property(
                                property: "email",
                                type: "string",
                                example: "employe@example.com"
                            ),
                            new OA\Property(
                                property: "apiToken",
                                type: "string",
                                example: "eyJ0eXAiOiJK..."
                            ),
                            new OA\Property(
                                property: "firstName",
                                type: "string",
                                example: "Bruno"
                            ),
                            new OA\Property(
                                property: "lastName",
                                type: "string",
                                example: "Bala"
                            ),
                            new OA\Property(
                                property: "roles",
                                type: "array",
                                items: new OA\Items(
                                    type: "string",
                                    example: ["ROLE_RESPONSABLE", "ROLE_USER"]
                                )
                            )
                        ]
                    )
                )
            ),
            new OA\Response(
                response: 400,
                description: "Données invalides ou email déjà utilisé",
                content: new OA\MediaType(
                    mediaType: "application/json",
                    schema: new OA\Schema(
                        type: "object",
                        properties: [
                            new OA\Property(
                                property: "error",
                                type: "string",
                                example: "Cet email est déjà utlisé"
                            )
                        ]
                    )
                )
            ),
            new OA\Response(
                response: 403,
                description: "Un compte administrateur existe déjà, accès interdit",
                content: new OA\MediaType(
                    mediaType: "application/json",
                    schema: new OA\Schema(
                        type: "object",
                        properties: [
                            new OA\Property(
                                property: "error",
                                type: "string",
                                example: "Un compte administrateur existe déjà"
                            )
                        ]
                    )
                )
            ),
            new OA\Response(
                response: 500,
                description: "Erreur interne du serveur",
                content: new OA\MediaType(
                    mediaType: "application/json",
                    schema: new OA\Schema(
                        type: "object",
                        properties: [
                            new OA\Property(
                                property: "error",
                                type: "string",
                                example: "Une erreur est survenue"
                            )
                        ]
                    )
                )
            )
        ]
    )]
    #[IsGranted('ROLE_ADMIN')]
    public function createResponsable(
        Request $request,
    ): JsonResponse {
        // Désérialisation de l'utilisateur depuis le contenu de la requête
        $user = $this->serializer
            ->deserialize(
                $request->getContent(),
                User::class,
                'json'
            );

        // Vérification de l'existence d'un utilisateur avec cet email
        $existingUser = $this->manager
            ->getRepository(User::class)
            ->findOneBy(
                ['email' => $user->getEmail()]
            );
        if ($existingUser) {
            return new JsonResponse(
                ['error' => 'Cet email est déjà utlisé'],
                Response::HTTP_BAD_REQUEST
            );
        }

        //Attribution du rôle d'employé
        $user->setRoles(['ROLE_RESPONSABLE']);

        // Si l'admin tente de créer un administrateur, vérifiez s'il existe déjà un administrateur
        if (in_array("ROLE_ADMIN", $user->getRoles())) {
            $existingAdmin = $this->manager
                ->getRepository(User::class)
                ->findOneByRole('ROLE_ADMIN');
            if ($existingAdmin) {
                return new JsonResponse(
                    ['error' => 'Un compte administrateur existe déjà'],
                    Response::HTTP_FORBIDDEN
                );
            }
        }

        // Hachage du mot de passe
        $user->setPassword(
            $this->passwordHasher->hashPassword(
                $user,
                $user->getPassword()
            )
        );

        $user->setCreatedAt(new DateTimeImmutable());

        $this->manager->persist($user);
        $this->manager->flush();

        return new JsonResponse(
            // ['message' => 'User registered successfully'],
            //Pour le test à supprimer avant production (mise en ligne)
            [
                'id' => $user->getId(),
                'user'  => $user->getUserIdentifier(),
                'apiToken' => $user->getApiToken(),
                'firstName' => $user->getFirstName(),
                'lastName' => $user->getLastName(),
                'roles' => $user->getRoles()
            ],
            Response::HTTP_CREATED
        );
    }
}
