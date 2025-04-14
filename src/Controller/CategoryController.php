<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
    #[Route('/', name: 'index', methods: 'GET')]
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
    #[Route(methods: 'POST')]
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

    #[Route('/{id}', name: 'show', methods: 'GET')]
    public function show(int $id): JsonResponse
    {
        $category = $this->repository->findOneBy(["id" => $id]);
        $responseData = $this->serializer->serialize($category, 'json');
        return new JsonResponse($responseData, Response::HTTP_OK, [], true);
    }

    #[Route('/{id}', name: 'edit', methods: 'PUT')]
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
