<?php

namespace App\Controller;

use App\Entity\Restaurant;
use App\Entity\User;
use App\Repository\RestaurantRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
    public function new(Request $request): JsonResponse
    {
        /** @var User $user */
        $data = json_decode($request->getContent(), true);
        $restaurant = $this->serializer->deserialize($request->getContent(), Restaurant::class, 'json');
        if ($data['owner']) {
            $owner = $this->manager->getRepository(User::class)->find($data['owner']);
            $restaurant->setOwner($owner);
        } else {
            return new JsonResponse(['erreur' => 'Utilisateur introuvable'], Response::HTTP_NOT_FOUND);
        }
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
            ['id' => $restaurant->getId()],
            UrlGeneratorInterface::ABSOLUTE_URL
        );
        return new JsonResponse($responseData, Response::HTTP_CREATED, ['Location' => $location], true);
    }


    #[Route('/{id}', name: 'show', methods: 'GET')]
    public function show(int $id): JsonResponse
    {
        $restaurant = $this->repository->findOneBy(["id" => $id]);
        $responseData = $this->serializer->serialize($restaurant, 'json', ['groups' => ['restaurant']]);
        return new JsonResponse($responseData, Response::HTTP_OK, [], true);
    }

    #[Route('/{id}', name: 'edit', methods: 'PUT')]
    public function edit(int $id, Request $request): JsonResponse
    {
        $restaurant = $this->repository->findOneBy(["id" => $id]);

        $data = json_decode($request->getContent(), true);
        if ($restaurant) {
            $restaurant = $this->serializer->deserialize(
                $request->getContent(),
                Restaurant::class,
                'json',
                [AbstractNormalizer::OBJECT_TO_POPULATE => $restaurant]
            );
            if ($data['owner']) {
                $owner = $this->manager->getRepository(User::class)->find($data['owner']);
                $restaurant->setOwner($owner);
            } else {
                return new JsonResponse(['erreur' => 'Utilisateur introuvable'], Response::HTTP_NOT_FOUND);
            }
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
