<?php

namespace App\Service\Filesystem;

abstract class FileSystem {

    protected function createRandomName(string $folder, $ext = null): string
    {
        do {
            $filename = uniqid() . '.' . $ext;
            $filePath = $folder . '/' . $filename;
        } while (file_exists($filePath));
        return $filename;
    }

    protected function makeNameFromOrigin($folder, $origin)
    {
        $fileName = basename($origin);
        $dotPointer = strrpos($fileName, '.');
        $name = substr($fileName, 0, $dotPointer);
        $extension = substr($fileName, $dotPointer + 1);

        $increment = 0;

        do {
            $fileName = $name . ($increment ? '_' . $increment : '') . ($extension ? '.' . $extension : '');
            $filePath = $folder . '/' . $fileName;
            $increment++;
        } while (file_exists($filePath));

        return $fileName;
    }

    protected function getPublicFolderPath(): string
    {
        return realpath(__DIR__ . '/../../../public');
    }

    public function checkAndCreatePublic($path)
    {
        $folder = $this->getPublicFolderPath() . '/' . trim($path , "\\/");
        if (!is_dir($folder) && !mkdir($folder)) {
            throw new \RuntimeException('Не можливо створити папку "' . $folder . '".');
        }
    }
}