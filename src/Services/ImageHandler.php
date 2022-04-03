<?php

namespace App\Services;

use App\Entity\Image;
use App\Entity\Post;

class ImageHandler
{
    const IMAGES_FOLDER = '/public/images';
    public function __construct(
        private string $path,
    )
    {
    }

    public function handle(Image $image): void
    {
        $name = md5(uniqid()) . '.' . $image->file->getClientOriginalName();
        $image->file->move($this->path.self::IMAGES_FOLDER, $name);

        $image->setName($name);
    }
}