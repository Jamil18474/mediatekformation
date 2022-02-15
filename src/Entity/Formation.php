<?php

namespace App\Entity;

use DateTime;
use DateTimeInterface;
use App\Repository\FormationRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * @ORM\Entity(repositoryClass=FormationRepository::class)
 */
class Formation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $publishedAt;

    /**
     * @ORM\Column(type="string", length=91, nullable=true)
     */
    private $title;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=46, nullable=true)
     */
    private $miniature;

    /**
     * @ORM\Column(type="string", length=48, nullable=true)
     */
    private $picture;

    /**
     * @ORM\Column(type="string", length=11, nullable=true)
     */
    private $videoId;

    /**
     * @ORM\ManyToOne(targetEntity=Niveau::class, inversedBy="formations")
     */
    private $niveau;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPublishedAt(): ?DateTimeInterface
    {
        return $this->publishedAt;
    }

    public function getPublishedAtString(): string {
        return $this->publishedAt->format('d/m/Y');     
    }    
        
    public function setPublishedAt(?DateTimeInterface $publishedAt): self
    {
        $this->publishedAt = $publishedAt;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

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

    public function getMiniature(): ?string
    {
        return $this->miniature;
    }

    public function setMiniature(?string $miniature): self
    {
        $this->miniature = $miniature;

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(?string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    public function getVideoId(): ?string
    {
        return $this->videoId;
    }

    public function setVideoId(?string $videoId): self
    {
        $this->videoId = $videoId;

        return $this;
    }

    public function getNiveau(): ?Niveau
    {
        return $this->niveau;
    }

    public function setNiveau(?Niveau $niveau): self
    {
        $this->niveau = $niveau;

        return $this;
    }
    
    public function getNiveauLibelle() : string {
        return $this->getNiveau()->getLibelle();
    }
    
    /**
     * Vérifie la conformité des images
     * @Assert\Callback
     */
    public function validateImages(ExecutionContextInterface $context)
    {
        if($this->getMiniature() != "")  {
            if(!exif_imagetype($this->getMiniature())) {
                $context->buildViolation("Veuillez insérer une image.")
                ->atPath('miniature')
                ->addViolation();
            } else {
                list($widthminiature, $heightminiature) = getimagesize($this->getMiniature());
                if($widthminiature != 120 || $heightminiature != 90) {
                    $context->buildViolation("Les dimensions de l'image sont incorrectes.")
                    ->atPath('miniature')
                    ->addViolation();
                }
            }
        }
        if($this->getPicture() != "") {
            if(!exif_imagetype($this->getPicture())) {
                $context->buildViolation("Veuillez insérer une image.")
                ->atPath('picture')
                ->addViolation();
            } else {
                list($widthpicture, $heightpicture) = getimagesize($this->getPicture());
                if($widthpicture > 640 || $heightpicture > 480) {
                    $context->buildViolation("Les dimensions de l'image sont trop grandes.")
                    ->atPath('picture')
                    ->addViolation();
                }
            }
        }
    }
}
