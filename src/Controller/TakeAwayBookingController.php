<?php

namespace App\Controller;

use App\Entity\Food;
use App\Entity\TakeAwayBooking;
use App\Repository\TakeAwayBookingRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
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
    #[Route('/', name: 'index')]
    public function index(): JsonResponse
    {
        $takeAwayBookings = $this->manager->getRepository(TakeAwayBooking::class)->findAll();
        $takeAwayBookings = $this->serializer->serialize($takeAwayBookings, 'json', ['groups' => ['takeAwayBookings', 'category', 'food', 'user:read']]);
        return new JsonResponse($takeAwayBookings, Response::HTTP_OK, [], true);
    }

    #[Route(name: 'new', methods: 'POST')]
    public function new(Request $request, Security $security): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        /** @var TakeAwayBooking $takeAwayBooking */
        $takeAwayBooking = new TakeAwayBooking();

        $user = $security->getUser();
        $takeAwayBooking->setUser($user);
        /** @var Food $food */
        $foods = $this->manager->getRepository(Food::class)->findByIds($data['food']);
        foreach ($foods as $food) {
            $takeAwayBooking->addFood($food);
        }
        // foreach ($takeAwayBooking->getFood() as $food) {
        //     $food->addTakeAwayBooking($takeAwayBooking);
        // }

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
    public function show(int $id): JsonResponse
    {
        $takeAwayBooking = $this->repository->findOneBy(['id' => $id]);
        $takeAwayBooking = $this->serializer->serialize($takeAwayBooking, 'json', ['groups' => ['takeAwayBookings', 'category', 'food', 'user:read']]);
        return new JsonResponse($takeAwayBooking, Response::HTTP_OK, [], true);
    }
    #[Route('/{id}', name: 'edit', methods: 'PUT')]
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
    public function delete(int $id): JsonResponse
    {
        $takeAwayBooking = $this->repository->findOneBy(['id' => $id]);
        $this->manager->remove($takeAwayBooking);
        $this->manager->flush();
        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }
}
