<?php

namespace App\Entity;

use App\Repository\BookRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BookRepository::class)]
class Book
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $title = null;


    #[ORM\Column(type: 'date', nullable: true)]
    private ?\DateTimeInterface $publicationDate = null;

    #[ORM\Column(nullable: true)]
    private ?bool $enabled = null;

    #[ORM\ManyToOne(inversedBy: 'yes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Author $author = null;



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    
    public function setTitle(?string $title): static
    {
        $this->title = $title;
        return $this;
    }

    
    public function getPublicationDate(): ?\DateTimeInterface
    {
        return $this->publicationDate;
    }

    
    public function setPublicationDate(?\DateTimeInterface $publicationDate): static
    {
        $this->publicationDate = $publicationDate;
        return $this;
    }

    public function isEnabled(): ?bool
    {
        return $this->enabled;
    }

    
    public function setEnabled(?bool $enabled): static
    {
        $this->enabled = $enabled;
        return $this;
    }

    public function getAuthor(): ?Author
    {
        return $this->author;
    }

    public function setAuthor(?Author $author): static
    {
        $this->author = $author;

        return $this;
    }



}
