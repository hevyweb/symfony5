<?php
namespace App\Service;

use App\Entity\Image;
use App\Entity\Oauth;
use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;
use Google\Auth\Credentials\UserRefreshCredentials;
use Google\Photos\Library\V1\PhotosLibraryClient;
use Google\Photos\Types\MediaItem;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class LoaderService
{
    /**
     * @var ManagerRegistry
     */
    private $doctrine;

    /**
     * @var ObjectManager
     */
    private $em;

    /**
     * @var DownloaderService
     */
    private $downloaderService;

    /**
     * @var string
     */
    private $googleClientId;

    /**
     * @var string
     */
    private $googleClientSecret;

    public function __construct(
        ManagerRegistry $doctrine,
        DownloaderService $downloaderService,
        string $googleClientId,
        string $googleClientSecret
    ) {
        $this->doctrine = $doctrine;
        $this->em = $doctrine->getManager();
        $this->downloaderService = $downloaderService;

        $this->googleClientId = $googleClientId;
        $this->googleClientSecret = $googleClientSecret;
    }

    /**
     * @param User $user
     * @param string|null $pageToken indicate page (offset) to be loaded
     * @return string|null next page token or null in case if there is nothing to load
     * @throws \Google\ApiCore\ApiException
     * @throws \Google\ApiCore\ValidationException
     */
    public function load(User $user, ?string $pageToken = null): ?string
    {
        $photosLibraryClient = new PhotosLibraryClient(['credentials' => $this->buildAuthCredentials($user)]);
        $params = [
            'pageSize' => 100
        ];

        if (!empty($pageToken)) {
            $params['pageToken'] = $pageToken;
        }

        $mediaItems = $photosLibraryClient->listMediaItems($params);
        $success = false;
        foreach ($mediaItems->getPage()->getIterator() as $mediaItem) {
            if ($this->isImage($mediaItem) && !$this->exists($mediaItem)) {
                $this->saveFile($mediaItem);
                $success = true;
            }
        }
        if (!$success) {
            return null;
        }
        return $mediaItems->getPage()->getNextPageToken();
    }

    private function getToken(User $user): Oauth
    {
        $token = $this->doctrine->getRepository(Oauth::class)->findOneBy([
            'user' => $user
        ]);
        if (empty($token)) {
            throw new NotFoundHttpException('Токен не існує.');
        }

        return $token;
    }

    private function buildAuthCredentials(User $user): UserRefreshCredentials
    {
        return new UserRefreshCredentials(
            'https://www.googleapis.com/auth/photoslibrary',
            [
                "client_id" => $this->googleClientId,
                "client_secret" => $this->googleClientSecret,
                "refresh_token" => $this->getToken($user)->getRefreshToken()
            ]
        );
    }

    private function saveFile(MediaItem $mediaItem): void
    {
        if (!$this->isImage($mediaItem)) {
            $this->saveVideo($mediaItem);
        } else {
            $this->saveImage($mediaItem);
        }
    }

    private function saveVideo(MediaItem $mediaItem): void
    {
        //@TODO implement later
    }

    private function saveImage(MediaItem $mediaItem): void
    {
        $image = new Image();
        $image->setCreatedAt($mediaItem->getMediaMetadata()->getCreationTime()->toDateTime())
            ->setDescription($mediaItem->getDescription())
            ->setApertureFNumber($mediaItem->getMediaMetadata()->getPhoto()->getApertureFNumber())
            ->setCameraMake($mediaItem->getMediaMetadata()->getPhoto()->getCameraMake())
            ->setFilename($mediaItem->getFilename())
            ->setFocalLength($mediaItem->getMediaMetadata()->getPhoto()->getFocalLength())
            ->setGoogleId($mediaItem->getId())
            ->setHeight($mediaItem->getMediaMetadata()->getHeight())
            ->setIsoEquivalent($mediaItem->getMediaMetadata()->getPhoto()->getIsoEquivalent())
            ->setPath($mediaItem->getBaseUrl())
            ->setType($mediaItem->getMimeType())
            ->setWidth($mediaItem->getMediaMetadata()->getWidth())
            ->setDeleted(false)
        ;

        $image->setLocalPath($this->downloaderService->download($image));

        $this->em->persist($image);
        $this->em->flush();
    }

    /**
     * If image has been already exist, no need to download it twice
     *
     * @param MediaItem $mediaItem
     * @return bool true is doesn't exist
     */
    private function exists(MediaItem $mediaItem): bool
    {
        $image = $this->doctrine
            ->getRepository(Image::class)
            ->findOneBy([
                'google_id' => $mediaItem->getId()
            ]);
        return !empty($image);
    }

    private function isImage(MediaItem $mediaItem): bool
    {
        if ($mediaItem->getMediaMetadata()->getVideo()) {
            return false;
        } else {
            return true;
        }
    }
}