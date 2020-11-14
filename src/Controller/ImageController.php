<?php

namespace App\Controller;

use Google\Auth\Credentials\UserRefreshCredentials;
use Google\Photos\Library\V1\PhotosLibraryClient;
use Google\Photos\Types\Album;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
            $authCredentials = new UserRefreshCredentials(
                'https://www.googleapis.com/auth/photoslibrary',
                [
                "client_id" => "174844681564-9bnui3ip778khv6riq7thpi81dbq89th.apps.googleusercontent.com",
                "client_secret" => "Ryn8Q6BptottX6PUTT30I6Qd",
                "refresh_token" => '1//0chFd3X-xUuD7CgYIARAAGAwSNwF-L9IrJe9JuGMoRIurAoIuaWFDOHWRvSP1cfKbBtWwEamGldDz1pSVHQq-tFfG5nFwYkEFpnY'
            ]);
            $photosLibraryClient = new PhotosLibraryClient(['credentials' => $authCredentials]);
            $albums = $photosLibraryClient->listAlbums();
            foreach ($albums as $album)
            {
                /**
                 * @var Album $album
                 */
                var_dump($album->getTitle());exit;
            }
        } catch (\Google\ApiCore\ApiException $e) {
            var_dump($e);exit;
        } catch (\Google\ApiCore\ValidationException $e) {
            var_dump($e);
        }
    }
}
