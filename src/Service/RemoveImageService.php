<?php

namespace App\Service;

use App\Entity\Image;
use App\Service\Filesystem\FileSystem;

class RemoveImageService extends FileSystem
{
    const ARCHIVED_FOLDER = 'archived';

    /**
     * @var string
     */
    private $photoLocalFolder;

    public function __construct(string $photoLocalFolder)
    {
        $this->photoLocalFolder = $photoLocalFolder;
    }

    public function remove(Image $image)
    {
        $publicFolder = $this->getPublicFolderPath();
        $publicPath = $publicFolder . '/' .$image->getLocalPath();

        $privateFolder = $this->getPrivatePath();
        $newFileName = $this->makeNameFromOrigin($privateFolder, $image->getFilename());
        $privatePath = $privateFolder . '/' . $newFileName;

        if (!rename($publicPath, $privatePath)) {
            throw new \RuntimeException('Не можливо заархівувати файл "' . $publicPath . '" у "' . $privatePath . '"');
        }

        $preview = $this->getPublicFolderPath() . '/' . ProcessImageService::THUMBNAIL_FOLDER . '/' . $image->getLocalPath();
        if (!unlink($preview)) {
            throw new \RuntimeException('Не можливо видалити прев\'ю "' . $preview . '"');
        }
        return $newFileName;
    }

    public function revoke(Image $image)
    {
        $publicFolder = $this->getPublicFolderPath() . '/' . $this->photoLocalFolder;
        $newFileName = $this->makeNameFromOrigin($publicFolder, $image->getFilename());
        $publicPath = $publicFolder . '/' . $newFileName;

        $privateFolder = $this->getPrivatePath();
        $privatePath = $privateFolder . '/' . $image->getLocalPath();

        if (!rename($privatePath, $publicPath)) {
            throw new \RuntimeException('Не можливо розархівувати файл "' . $privatePath . '" у "' . $publicPath . '"');
        }

        return $this->photoLocalFolder . '/' . $newFileName;
    }

    private function getPrivatePath()
    {
        return realpath(__DIR__ . '/../../' . self::ARCHIVED_FOLDER);
    }
}