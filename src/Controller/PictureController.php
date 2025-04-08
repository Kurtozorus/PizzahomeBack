<?php

namespace App\Controller;

use App\Entity\Food;
use App\Entity\Picture;
use App\Entity\Restaurant;
use App\Repository\PictureRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Serializer\SerializerInterface as SerializerSerializerInterface;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/api/picture', name: 'app_api_picture_')]
final class PictureController extends AbstractController
{
    private string $uploadDir;
    public function __construct(
        private EntityManagerInterface $manager,
        private SerializerSerializerInterface $serializer,
        private PictureRepository $pictureRepository,
        private UrlGeneratorInterface $urlGenerator,
        private ValidatorInterface $validator,
        private KernelInterface $kernel,
        private SluggerInterface $slugger
    ) {
        // Définition du répertoire d'upload des images
        $this->uploadDir = $this->kernel->getProjectDir() . '/public/uploads/pictures/';
    }
    #[Route('/', name: 'index', methods: 'GET')]
    public function index(): JsonResponse
    {
        $picture = $this->manager->getRepository(Picture::class)->findAll();
        $pictureList = array_map(function (Picture $picture) {
            return [
                'id' => $picture->getId(),
                'url' => $picture->getPublicPath(),
            ];
        }, $picture);
        return new JsonResponse(
            ['pictures' => $pictureList],
            JsonResponse::HTTP_OK
        );
    }
    #[Route(name: 'new', methods: 'POST')]
    public function new(Request $request): JsonResponse
    {
        //Récupération des données envoyées par le client
        $title = $request->get('title');
        $slug = $request->get('slug');
        $fileData = $request->get('fileData'); // Image en Base64
        $pictureFile = $request->files->get('picture'); // Image envoyée en fichier


        if (!$title || !$slug || (!$pictureFile && empty($fileData))) {
            return new JsonResponse(
                [
                    'error' => 'Champ(s) olbigatoire manquant(s)'
                ],
                Response::HTTP_BAD_REQUEST
            );
        }

        //Définition des types MIME autorisés
        $allowedMimeTypes = [
            'image/jpeg',
            'image/jpg',
            'image/png',
            'image/gif',
            'image/webp'
        ];
        $maxSize = 5 * 1024 * 1024; // 5MB
        //Génération d'un nom de fichier unique
        $fileName = uniqid('', true);

        if ($pictureFile) {
            //Vérification du type MIME du fichier
            $mimeType = $pictureFile->getMimeType();
            if (!in_array($mimeType, $allowedMimeTypes)) {
                return new JsonResponse(
                    ['error' => 'Type de fichier invalide'],
                    Response::HTTP_BAD_REQUEST
                );
            }

            //Vérification de la taille du fichier
            if ($pictureFile->getSize() > $maxSize) {
                return new JsonResponse(
                    ['error' => 'Fichier trop grand'],
                    Response::HTTP_BAD_REQUEST
                );
            }

            //Récupération et ajout de l'extension au nom du fichier
            $extension = $pictureFile->guessExtension();
            $fileName .= '.' . $extension;

            //Déplacement du fichier vers un dossier sécurisé (hors de l'accès direct du public)
            $pictureFile->move($this->uploadDir, $fileName);
        } else {
            //Vérification et décodage des données Base64
            $fileContent = base64_decode($fileData, true);
            if (!$fileContent) {
                return new JsonResponse(
                    ['error' => 'Données Base64 invalides'],
                    Response::HTTP_BAD_REQUEST
                );
            }

            //Vérification du type MIME après décodage
            $finfo = new \finfo(FILEINFO_MIME_TYPE);
            $mimeType = $finfo->buffer($fileContent);
            if (!in_array($mimeType, $allowedMimeTypes)) {
                return new JsonResponse(
                    ['error' => 'Type de fichier base64 invalide'],
                    Response::HTTP_BAD_REQUEST
                );
            }

            //Génération du nom de fichier avec une extension sécurisée
            $fileName .= '.jpg'; // On force l'extension jpg pour éviter l'exécution de scripts malveillants
            file_put_contents(
                $this->uploadDir . '/' . $fileName,
                $fileContent
            );
        }

        //Génération d'une URL sécurisée pour l'accès à l'image
        $fileUrl = $request->getSchemeAndHttpHost() . '/uploads/pictures/' . $fileName;

        //Création d'une entité Picture et assignation des données
        $picture = new Picture();
        $picture->setPublicPath($fileUrl);
        $picture->setLocalPath($fileName);
        //Protection contre XSS
        $picture->setTitle(
            htmlspecialchars(
                $title,
                ENT_QUOTES,
                'UTF-8'
            ),
            $this->slugger
        );
        //Protection contre XSS
        $picture->setSlug(
            htmlspecialchars(
                $slug,
                ENT_QUOTES,
                'UTF-8'
            )
        );

        $picture->setCreatedAt(new \DateTimeImmutable());

        $restaurantId = $request->get('restaurant_id');
        if (!$restaurantId) {
            return new JsonResponse(['erreur' => 'restaurant_id manquant'], Response::HTTP_BAD_REQUEST);
        }

        $restaurant = $this->manager->getRepository(Restaurant::class)->find($restaurantId);
        if (!$restaurant) {
            return new JsonResponse(['erreur' => 'Restaurant introuvable'], Response::HTTP_NOT_FOUND);
        }

        $picture->setRestaurant($restaurant);

        $foodId = $request->get('food_id');
        if (!$foodId) {
            return new JsonResponse(['erreur' => 'food_id manquant'], Response::HTTP_BAD_REQUEST);
        }

        $food = $this->manager->getRepository(Food::class)->find($foodId);
        if (!$food) {
            return new JsonResponse(['erreur' => 'Plat introuvable'], Response::HTTP_NOT_FOUND);
        }

        $picture->setFood($food);

        //Validation des données de l'entité avant de l'enregistrer
        $errors = $this->validator->validate($picture);
        if (count($errors) > 0) {
            return new JsonResponse(
                ['error' => (string) $errors],
                Response::HTTP_BAD_REQUEST
            );
        }

        //Sauvegarde en base de données
        $this->manager->persist($picture);
        $this->manager->flush();

        //Réponse JSON avec un message de succès
        return new JsonResponse(
            [
                'status' => 'success',
                'message' => 'Image uploaded avec succes',
                'image' => [
                    'id' => $picture->getId(),
                    'title' => $picture->getTitle(),
                    'slug' => $picture->getSlug(),
                    'publicPath' => $picture->getPublicPath(),
                    'localPath' => $picture->getLocalPath(),
                    'createdAt' => $picture->getCreatedAt()->format("d-m-Y")
                ]
            ],
            Response::HTTP_CREATED
        );
    }

    #[Route('/{id}', name: 'show', methods: ['GET'])]
    public function show(int $id, Request $request): JsonResponse|BinaryFileResponse
    {
        $picture = $this->manager->getRepository(Picture::class)->find($id);

        if (!$picture || !$picture->getLocalPath()) {
            return new JsonResponse(['error' => 'Image introuvable'], Response::HTTP_NOT_FOUND);
        }

        // Chemin absolu vers le fichier image
        $localPath = realpath($this->uploadDir . DIRECTORY_SEPARATOR . $picture->getLocalPath());

        // Sécurisation contre les attaques path traversal
        if (!$localPath || strpos($localPath, realpath($this->uploadDir)) !== 0) {
            return new JsonResponse(['error' => 'Accès refusé !'], Response::HTTP_FORBIDDEN);
        }

        // Vérifie l’existence physique du fichier
        if (!file_exists($localPath) || !is_readable($localPath)) {
            return new JsonResponse(['error' => 'Fichier introuvable'], Response::HTTP_NOT_FOUND);
        }

        // Si ?view=image → retourner directement le fichier image
        if ($request->query->get('view') === 'image') {
            $response = new BinaryFileResponse($localPath);
            $response->headers->set('Content-Type', mime_content_type($localPath));
            $response->setContentDisposition(
                ResponseHeaderBag::DISPOSITION_INLINE,
                basename($localPath)
            );
            return $response;
        }

        // Sinon → retourner les infos de l’image
        $food = $picture->getFood();
        $restaurant = $picture->getRestaurant();

        return new JsonResponse([
            'status' => 'success',
            'image' => [
                'id' => $picture->getId(),
                'title' => $picture->getTitle(),
                'slug' => $picture->getSlug(),
                'publicPath' => $picture->getPublicPath(),
                'localPath' => $picture->getLocalPath(),
                'createdAt' => $picture->getCreatedAt()->format("d-m-Y"),
                'restaurant' => $restaurant ? [
                    'id' => $restaurant->getId(),
                    'name' => $restaurant->getName(),
                ] : null,
                'food' => $food ? [
                    'id' => $food->getId(),
                    'name' => $food->getTitle(),
                ] : null,
            ]
        ]);
    }
    #[Route('/{id}', name: 'edit', methods: ['POST'])]
    public function edit(
        int $id,
        Request $request,
        UrlGeneratorInterface $urlGenerator
    ): Response {
        // Récupérer l'image depuis la base de données
        $picture = $this->manager->getRepository(Picture::class)->find($id);

        if (!$picture) {
            return new JsonResponse(
                ['error' => 'Image introuvable'],
                Response::HTTP_NOT_FOUND
            );
        }

        // Récupérer et mettre à jour le titre et le slug (s'ils sont fournis)
        $title = $request->request->get('title');
        $slug = $request->request->get('slug');

        if ($title) {
            $picture->setTitle($title);
        }
        if ($slug) {
            $picture->setSlug($slug);
        }

        // Récupérer le fichier envoyé
        $uploadedFile = $request->files->get('picture');

        // Vérification qu'au moins un champ est fourni
        if (!$title && !$slug && !$uploadedFile) {
            return new JsonResponse(
                ['error' => 'Aucun changement fourni'],
                Response::HTTP_BAD_REQUEST
            );
        }

        if ($uploadedFile) {
            // Vérifier l'extension et le type MIME
            $allowedExtensions = [
                'jpg',
                'jpeg',
                'png',
                'gif',
                'webp'
            ];
            $allowedMimeTypes = [
                'image/jpeg',
                'image/png',
                'image/gif',
                'image/webp'
            ];

            $fileExtension = strtolower($uploadedFile->getClientOriginalExtension());
            $mimeType = $uploadedFile->getMimeType();

            if (!in_array($fileExtension, $allowedExtensions) || !in_array($mimeType, $allowedMimeTypes)) {
                return new JsonResponse(
                    ['error' => 'Type de fichier invalide'],
                    Response::HTTP_BAD_REQUEST
                );
            }

            // Supprimer l'ancien fichier s'il existe
            $oldPublicPath = $this->uploadDir . $picture->getLocalPath();
            if (file_exists($oldPublicPath) && is_file($oldPublicPath)) {
                unlink($oldPublicPath);
            }

            // Générer un nouveau nom de fichier
            $fileName = uniqid() . '-' . preg_replace(
                '/[^a-zA-Z0-9\._-]/',
                '',
                $uploadedFile->getClientOriginalName()
            );

            // Vérification et création du dossier d'upload si nécessaire
            if (!is_dir($this->uploadDir) && !mkdir($this->uploadDir, 0775, true)) {
                return new JsonResponse(
                    ['error' => 'Échec de la création du répertoire de téléchargement'],
                    Response::HTTP_INTERNAL_SERVER_ERROR
                );
            }

            // Déplacement du fichier
            try {
                $uploadedFile->move($this->uploadDir, $fileName);
            } catch (FileException $e) {
                return new JsonResponse(
                    ['error' => 'Échec du téléchargement du fichier'],
                    Response::HTTP_INTERNAL_SERVER_ERROR
                );
            }

            // Mise à jour de l'image
            $picture->setPublicPath('/uploads/pictures/' . $fileName);
            $picture->setLocalPath($fileName);
        }

        // Mettre à jour la date de modification
        $picture->setUpdatedAt(new DateTimeImmutable());

        $restaurantId = $request->get('restaurant_id');
        if (!$restaurantId) {
            return new JsonResponse(['erreur' => 'restaurant_id manquant'], Response::HTTP_BAD_REQUEST);
        }

        $restaurant = $this->manager->getRepository(Restaurant::class)->find($restaurantId);
        if (!$restaurant) {
            return new JsonResponse(['erreur' => 'Restaurant introuvable'], Response::HTTP_NOT_FOUND);
        }

        $picture->setRestaurant($restaurant);

        $foodId = $request->get('food_id');
        if (!$foodId) {
            return new JsonResponse(['erreur' => 'food_id manquant'], Response::HTTP_BAD_REQUEST);
        }

        $food = $this->manager->getRepository(Food::class)->find($foodId);
        if (!$food) {
            return new JsonResponse(['erreur' => 'Plat introuvable'], Response::HTTP_NOT_FOUND);
        }

        $picture->setFood($food);

        $this->manager->flush();

        // Chemin absolu du fichier (corrigé)
        $localPath = $this->getParameter('kernel.project_dir') . '/public' . $picture->getPublicPath();

        // Vérification de l'existence du fichier
        if (!file_exists($localPath)) {
            return new JsonResponse(
                ['error' => 'Fichier non trouvé après téléchargement'],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }

        // Générer l'URL de l'image dans le navigateur
        $imageUrl = $urlGenerator->generate(
            'app_api_picture_show',
            ['id' => $id, 'view' => 'image'],
            UrlGeneratorInterface::ABSOLUTE_URL
        );

        // Retourner l'image si demandée en tant qu'affichage
        if ($request->query->get('view') === 'image') {
            $response = new BinaryFileResponse($localPath);
            $response->headers->set('Content-Type', mime_content_type($localPath));
            $response->setContentDisposition(ResponseHeaderBag::DISPOSITION_INLINE, basename($localPath));
            return $response;
        }

        return new JsonResponse([
            'status' => 'success',
            'id' => $picture->getId(),
            'title' => $picture->getTitle(),
            'slug' => $picture->getSlug(),
            'publicPath' => $picture->getPublicPath(),
            'imageUrl' => $imageUrl,
            'createdAt' => $picture->getCreatedAt()->format("d-m-Y H:i:s"),
            'updatedAt' => $picture->getUpdatedAt()->format("d-m-Y H:i:s")
        ], Response::HTTP_OK);
    }
    #[Route('/{id}', name: 'delete', methods: ['DELETE'])]
    public function delete(int $id): JsonResponse
    {
        $picture = $this->manager->getRepository(Picture::class)->find($id);
        if (!$picture) {
            return new JsonResponse(['error' => 'Image introuvable'], Response::HTTP_NOT_FOUND);
        }
        //Supprimer le fichier du serveur
        $publicPath = $this->uploadDir . '/' . $picture->getLocalPath();
        if (file_exists($publicPath) && is_file($publicPath)) {
            unlink($publicPath);
        }
        $this->manager->remove($picture);
        $this->manager->flush();
        return new JsonResponse(['status' => 'Image supprimée avec succès'], Response::HTTP_OK);
    }
}
