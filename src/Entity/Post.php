<?php

namespace App\Entity;

use App\Repository\PostRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PostRepository::class)]
class Post
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[Assert\NotBlank]
    #[ORM\Column(type: 'string', length: 255)]
    private $title;

    #[Assert\NotBlank]
    #[ORM\Column(type: 'string', length: 10000, nullable: true)]
    private $content;

    #[ORM\OneToOne(targetEntity: "Image" ,  cascade: ['persist', 'remove'])]
    private $image;

    #[ORM\OneToMany(targetEntity: Keyword::class , mappedBy: 'post' ,  cascade: ['persist', 'remove'])]
    public $keywords;

    #[ORM\ManyToMany(targetEntity: Category::class, inversedBy: 'posts')]
    public $categories;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $author;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $language;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
        $this->keywords = new ArrayCollection();
    }

    public function getKeywords()
    {
        return $this->keywords;
    }

    public function addKeywords(Keyword $keyword)
    {
        $this->keywords->add($keyword);
        $keyword->setPost($this);
    }

    public function removeKeywords(Keyword $keyword)
    {
        $this->keywords->removeElement($keyword);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getImage(): ?Image
    {
        return $this->image;
    }

    public function setImage($image): void
    {
        $this->image = $image;
    }

    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategories(Category $category): self
    {
        $this->keywords->add($category);
        $category->addPost($this);

        return $this;
    }

    public function removeCategories(Category $category): self
    {
        $this->categories->removeElement($category);

        return $this;
    }

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function setAuthor(?string $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getLanguage(): ?string
    {
        return $this->language;
    }

    public function setLanguage(?string $language): self
    {
        $this->language = $language;

        return $this;
    }

}
