<?php


namespace App\Service;


use App\Entity\Image;
use App\Exception\ConversionException;
use App\Service\Filesystem\FileSystem;
use Doctrine\ORM\NoResultException;
use Doctrine\Persistence\ManagerRegistry;

class ProcessImageService extends FileSystem
{
    private $containerWidth = 256;

    private $containerHeight = 256;

    const THUMBNAIL_FOLDER = 'thumbnail';

    /**
     * @var ManagerRegistry
     */
    private $doctrine;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    public function getImage(): ?Image
    {
        return $this->doctrine->getRepository(Image::class)->findOneBy([
            'processed_at' => null
        ]);
    }

    public function process()
    {
        $image = $this->getImage();

        if (empty($image)) {
            throw new NoResultException();
        }

        $this->resize($image);
        $image->setProcessedAt(new \DateTime());
        $manager = $this->doctrine->getManager();
        $manager->persist($image);
        $manager->flush();
    }

    private function resize(Image $image)
    {
        list($width, $height) = $this->calculateSize($image);
        $originPath = $this->getOriginPath($image);
        $thumbnailPath = $this->getThumbnailPath($image);
        exec('ffmpeg -y -hide_banner -loglevel panic -i ' . $originPath . ' -vf scale=' . $width . ':' . $height . ' ' . $thumbnailPath, $output, $return);
        if ($return) {
            throw new ConversionException('Не можливо створити зменшене зображення для "' . $originPath . '"');
        }
    }

    private function getOriginPath(Image $image)
    {
        $originPath = $this->getPublicFolderPath() . '/' . $image->getLocalPath();
        if (!is_file($originPath) || !is_readable($originPath)) {
            throw new \RuntimeException('Файл "' . $originPath . '" не існує, або до нього нема лоступу.');
        }
        return $originPath;
    }

    private function getThumbnailPath(Image $image): string
    {
        return $this->getPublicFolderPath() . '/' . self::THUMBNAIL_FOLDER . '/' . $image->getLocalPath();
    }

    private function calculateSize(Image $image)
    {
        if ($image->getWidth() > $image->getHeight()) {
            $height = $this->containerHeight;
            $width = ceil(($height/$image->getHeight())*$image->getWidth());
        } else {
            $width = $this->containerWidth;
            $height = ceil(($width/$image->getWidth())*$image->getHeight());
        }
        return [$width, $height];
    }

}