<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Entity\User;
use App\Repository\BookingRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
    #[Route('/', name: 'index', methods: 'GET')]
    public function index(): JsonResponse
    {
        $booking = $this->manager->getRepository(Booking::class)->findAll();
        $booking = $this->serializer->serialize($booking, 'json', ['groups' => ['bookings']]);
        return new JsonResponse($booking, Response::HTTP_OK, [], true);
    }

    #[Route(name: 'new', methods: 'POST')]
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
    #[Route('/{id}', name: 'show', methods: 'GET')]
    public function show(int $id): JsonResponse
    {
        $booking = $this->repository->findOneBy(['id' => $id]);
        $responseData = $this->serializer->serialize($booking, 'json', ['groups' => ['bookings']]);
        return new JsonResponse($responseData, Response::HTTP_OK, [], true);
    }
    #[Route('/{id}', name: 'edit', methods: 'PUT')]
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
    public function delete(int $id): JsonResponse
    {
        $booking = $this->repository->findOneBy(['id' => $id]);
        if ($booking) {
            $this->manager->remove($booking);
            $this->manager->flush();
            return new JsonResponse(['status' => 'succès', 'message' => 'La reservation a été supprimée avec succès'], Response::HTTP_OK);
        }
        return new JsonResponse(null, Response::HTTP_NOT_FOUND);
    }
}
