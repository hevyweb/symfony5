<?php

namespace App\Entity;

use App\Repository\ImageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\UniqueConstraint;

/**
 * @ORM\Entity(repositoryClass=ImageRepository::class)
 * @ORM\Table(name="image", uniqueConstraints={@UniqueConstraint(name="google_id", columns={"google_id"})})
 */
class Image
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $filename;

    /**
     * @ORM\Column(type="text")
     */
    private $path;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $downloaded_at;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $cameraMake;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $cameraModel;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $focalLength;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $apertureFNumber;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $isoEquivalent;

    /**
     * @ORM\Column(type="integer")
     */
    private $width;

    /**
     * @ORM\Column(type="integer")
     */
    private $height;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $google_id;

    /**
     * @ORM\ManyToMany(targetEntity=Album::class, inversedBy="images")
     */
    private $album;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $locked_at;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $local_path;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $processed_at;

    /**
     * @ORM\Column(type="boolean")
     */
    private $deleted;

    public function __construct()
    {
        $this->album = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFilename(): ?string
    {
        return $this->filename;
    }

    public function setFilename(string $filename): self
    {
        $this->filename = $filename;

        return $this;
    }

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function setPath(string $path): self
    {
        $this->path = $path;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getDownloadedAt(): ?\DateTimeInterface
    {
        return $this->downloaded_at;
    }

    public function setDownloadedAt(\DateTimeInterface $downloaded_at): self
    {
        $this->downloaded_at = $downloaded_at;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getCameraMake(): ?string
    {
        return $this->cameraMake;
    }

    public function setCameraMake(?string $cameraMake): self
    {
        $this->cameraMake = $cameraMake;

        return $this;
    }

    public function getCameraModel(): ?string
    {
        return $this->cameraModel;
    }

    public function setCameraModel(?string $cameraModel): self
    {
        $this->cameraModel = $cameraModel;

        return $this;
    }

    public function getFocalLength(): ?float
    {
        return $this->focalLength;
    }

    public function setFocalLength(?float $focalLength): self
    {
        $this->focalLength = $focalLength;

        return $this;
    }

    public function getApertureFNumber(): ?float
    {
        return $this->apertureFNumber;
    }

    public function setApertureFNumber(?float $apertureFNumber): self
    {
        $this->apertureFNumber = $apertureFNumber;

        return $this;
    }

    public function getIsoEquivalent(): ?int
    {
        return $this->isoEquivalent;
    }

    public function setIsoEquivalent(?int $isoEquivalent): self
    {
        $this->isoEquivalent = $isoEquivalent;

        return $this;
    }

    public function getWidth(): ?int
    {
        return $this->width;
    }

    public function setWidth(int $width): self
    {
        $this->width = $width;

        return $this;
    }

    public function getHeight(): ?int
    {
        return $this->height;
    }

    public function setHeight(int $height): self
    {
        $this->height = $height;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getGoogleId(): ?string
    {
        return $this->google_id;
    }

    public function setGoogleId(string $google_id): self
    {
        $this->google_id = $google_id;

        return $this;
    }

    /**
     * @return Collection|Album[]
     */
    public function getAlbum(): Collection
    {
        return $this->album;
    }

    public function addAlbum(Album $album): self
    {
        if (!$this->album->contains($album)) {
            $this->album[] = $album;
        }

        return $this;
    }

    public function removeAlbum(Album $album): self
    {
        if ($this->album->contains($album)) {
            $this->album->removeElement($album);
        }

        return $this;
    }

    public function getLockedAt(): ?\DateTimeInterface
    {
        return $this->locked_at;
    }

    public function setLockedAt(?\DateTimeInterface $locked_at): self
    {
        $this->locked_at = $locked_at;

        return $this;
    }

    public function getLocalPath(): ? string
    {
        return $this->local_path;
    }

    public function setLocalPath(string $localPath): self
    {
        $this->local_path = $localPath;
        return $this;
    }

    public function getProcessedAt(): ?\DateTimeInterface
    {
        return $this->processed_at;
    }

    public function setProcessedAt(?\DateTimeInterface $processed_at): self
    {
        $this->processed_at = $processed_at;

        return $this;
    }

    public function getDeleted(): ?bool
    {
        return $this->deleted;
    }

    public function setDeleted(bool $deleted): self
    {
        $this->deleted = $deleted;

        return $this;
    }
}
