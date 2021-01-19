<?php

namespace App\Service;

use App\Entity\Image;
use App\Service\Filesystem\FileSystem;
use Doctrine\Migrations\Configuration\Exception\FileNotFound;

class DownloaderService extends FileSystem
{
    /**
     * @var string
     */
    private $photoLocalFolder;

    public function __construct(string $photoLocalFolder)
    {
        $this->photoLocalFolder = $photoLocalFolder;
    }

    public function download(Image $image)
    {
        $folder = $this->getPublicFolderPath() . '/' . $this->photoLocalFolder;
        $filename = $this->makeNameFromOrigin($folder, $image->getFilename());
        $filePath = $folder . '/' . $filename;
        $fileData = file_get_contents($image->getPath() . '=d');
        if (!$fileData) {
            throw new FileNotFound('Not able to download file from "' . $image->getPath() . '"');
        }
        if (!file_put_contents($filePath, $fileData)) {
            throw new \RuntimeException('Not able to save local file "' . $filePath . '"');
        }

        return $this->photoLocalFolder . '/' . $filename;
    }
}