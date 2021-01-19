<?php

namespace App\Service;

use App\Entity\Image;
use App\Service\Filesystem\FileSystem;

class RemoveImageService extends FileSystem
{
    const ARCHIVED_FOLDER = 'archived';

    public function remove(Image $image)
    {
        $publicFolder = $this->getPublicFolderPath();
        $publicPath = $publicFolder . '/' .$image->getLocalPath();

        $privateFolder = realpath(__DIR__ . '/../../' . self::ARCHIVED_FOLDER);
        $privatePath = $privateFolder . '/' . $this->makeNameFromOrigin($privateFolder, $image->getFilename());

        if (!rename($publicPath, $privatePath)) {
            throw new \RuntimeException('Не можливо заархівувати файл "' . $publicPath . '" у "' . $privatePath . '"');
        }

        $preview = $this->getPublicFolderPath() . '/' . ProcessImageService::THUMBNAIL_FOLDER . '/' . $image->getLocalPath();
        if (!unlink($preview)) {
            throw new \RuntimeException('Не можливо видалити прев\'ю "' . $preview . '"');
        }
    }
}