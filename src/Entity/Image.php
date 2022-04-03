<?php

namespace App\Entity;

use App\Repository\ImageRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;

#[ORM\Entity(repositoryClass: ImageRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Image
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    public $file;

    private $path;

    public function getPath()
    {
        return $this->path;
    }

    public function setPath($path): void
    {
        $this->path = $path;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getFile(): ?string
    {
        return $this->file;
    }

    public function setFile(UploadedFile $file): void
    {
        $this->file = $file;
    }

    #[ORM\PreFlush]
    public function handle(): void
    {
        if ($this->file === null) {
            return;
        }
//        dd($this->path);
        if ($this->id) {
            unlink( $this->path.'/'.$this->name);
        }
        $name = $this->createName();
        $this->file->move($this->path, $name);
        $this->setName($name);
    }

    private function createName()
    {
        return md5(uniqid()) . '.' . $this->file->getClientOriginalName();
    }

}
