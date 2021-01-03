<?php

namespace App\Controller;

use App\Entity\Image;
use App\Entity\Oauth;
use Google\Auth\Credentials\UserRefreshCredentials;
use Google\Photos\Library\V1\PhotosLibraryClient;
use Google\Photos\Types\Album;
use Google\Photos\Types\MediaItem;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class ImageController extends AbstractController
{
    /**
     * List of all users
     *
     * @Route("/images", name="images")
     */
    public function test()
    {
        try {
            $token = $this->getDoctrine()->getRepository(Oauth::class)->findOneBy([
                'user' => $this->getUser()
            ]);
            if (empty($token)) {
                throw new NotFoundHttpException('Токен не існує.');
            }
            $authCredentials = new UserRefreshCredentials(
                'https://www.googleapis.com/auth/photoslibrary',
                [
                "client_id" => $this->getParameter('google_client_id'),
                "client_secret" => $this->getParameter('google_client_secret'),
                "refresh_token" => $token->getRefreshToken()
                ]);
            $photosLibraryClient = new PhotosLibraryClient(['credentials' => $authCredentials]);
            $mediaItems = $photosLibraryClient->listMediaItems([
                'pageSize' => 100,
                'pageToken' => null
            ]);
            $manager = $this->getDoctrine()->getManager();
            foreach ($mediaItems as $mediaItem) {
                /**
                 * @var MediaItem $mediaItem
                 */
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
                    ->setWidth($mediaItem->getMediaMetadata()->getWidth());

                $manager->persist($image);
                $manager->flush();
                exit;
            }
        } catch (\Google\ApiCore\ApiException $e) {
            var_dump($e);exit;
        } catch (\Google\ApiCore\ValidationException $e) {
            var_dump($e);
        }
    }
}
