<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Food;
use App\Entity\TakeAwayBooking;
use App\Repository\FoodRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
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
    #[Route('/', name: 'index', methods: 'GET')]
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

    #[Route(methods: 'POST')]
    public function new(Request $request): JsonResponse
    {
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
        // if ($data['takeAwayBooking']) {
        //     $takeAwayBooking = $this->manager->getRepository(TakeAwayBooking::class)->find($data['takeAwayBooking']);
        //     if ($takeAwayBooking) {
        //         $food->addTakeAwayBooking($takeAwayBooking);
        //     } else {
        //         return new JsonResponse(['error' => 'Commande à emporter introuvable'], Response::HTTP_NOT_FOUND);
        //     }
        // }

        $this->manager->persist($food);
        $this->manager->flush();

        $responseData = $this->serializer->serialize($food, 'json', ['groups' => ["food", "category"]]);
        $location = $this->urlGenerator->generate(
            'app_api_food_show',
            ['id' => $food->getId()],
            UrlGeneratorInterface::ABSOLUTE_URL
        );
        return new JsonResponse($responseData, Response::HTTP_CREATED, ['Location' => $location], true);
    }

    #[Route('/{id}', name: 'show', methods: 'GET')]
    public function show(int $id): JsonResponse
    {
        $food = $this->repository->findOneBy(['id' => $id]);
        $responseData = $this->serializer->serialize($food, 'json', ['groups' => ["food", "category"]]);
        return new JsonResponse($responseData, Response::HTTP_OK, [], true);
    }

    #[Route('/{id}', name: 'edit', methods: 'PUT')]
    public function edit(int $id, Request $request): JsonResponse
    {
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
        // if ($data['takeAwayBooking']) {
        //     $takeAwayBooking = $this->manager->getRepository(TakeAwayBooking::class)->find($data['takeAwayBooking']);
        //     if ($takeAwayBooking) {
        //         $food->addTakeAwayBooking($takeAwayBooking);
        //     } else {
        //         return new JsonResponse(['error' => 'Commande à emporter introuvable'], Response::HTTP_NOT_FOUND);
        //     }
        // }

        $this->manager->flush();

        $responseData = $this->serializer->serialize($food, 'json', ['groups' => ["food", "category"]]);
        $location = $this->urlGenerator->generate(
            'app_api_food_show',
            ['id' => $food->getId()],
            UrlGeneratorInterface::ABSOLUTE_URL
        );
        return new JsonResponse($responseData, Response::HTTP_CREATED, ['Location' => $location], true);
    }

    #[Route('/{id}', name: 'delete', methods: 'DELETE')]
    public function delete(int $id): JsonResponse
    {
        $food = $this->repository->findOneBy(['id' => $id]);
        if ($food) {
            $this->manager->remove($food);
            $this->manager->flush();
            return new JsonResponse(['status' => 'succès', 'message' => 'Le plat a été supprimé avec succès'], Response::HTTP_OK);
        }
        return new JsonResponse(null, Response::HTTP_NOT_FOUND);
    }
}
