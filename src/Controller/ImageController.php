<?php

namespace App\Controller;

use App\Entity\Image;
use App\Repository\ImageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/image')]
class ImageController extends AbstractController
{
    private const ALLOWED_MIME_TYPES = ['image/png', 'image/jpeg', 'image/gif', 'image/webp'];
    private const ALLOWED_EXTENSIONS = ['png', 'jpg', 'jpeg', 'gif', 'webp'];

    public function __construct(
        private readonly ImageRepository $imageRepository,
        private readonly EntityManagerInterface $em,
    ) {}

    #[Route(path: '/', name: 'app_home', methods: ['GET'])]
    public function home(): Response
    {
        return $this->render('base.html.twig');
    }

    #[Route(path: '/get', name: 'app_get', methods: ['GET'])]
    public function get(): Response
    {
        return new JsonResponse($this->imageRepository->findAll());
    }

    #[Route(path: '/upload', name: 'app_upload_file', methods: ['POST'])]
    public function new(Request $request): Response
    {
        $entity = new image();
        $entity->setName($request->request->get('name'));

        /** @var UploadedFile $file */
        $file = $request->files->get('file');

        if (
            !in_array($file->getClientMimeType(), self::ALLOWED_MIME_TYPES, true)
            || $file->getSize() > 5 * 1024 * 1024
        ) {
            throw new BadRequestHttpException();
        }
        if (
            !in_array($file->getClientOriginalExtension(), self::ALLOWED_EXTENSIONS, true)
        ) {
            throw new BadRequestHttpException();
        }

        $storagePath = 'uploads/pictures/';
        $newFileName = str_replace(' ', '_', $entity->getName()) . uniqid() . '.' . $file->guessExtension();
        $file->move($this->getParameter('kernel.project_dir') . '/public/' . $storagePath, $newFileName);

        $entity->setFilePath($storagePath . '/' . $newFileName);

        $this->em->persist($entity);
        $this->em->flush();

        return new JsonResponse($entity);
    }
}
