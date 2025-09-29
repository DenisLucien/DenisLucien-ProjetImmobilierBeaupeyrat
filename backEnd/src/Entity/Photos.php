<?php

namespace App\Entity;

use App\Repository\PhotosRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PhotosRepository::class)]
class Photos
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $source = null;

 #[ORM\ManyToOne(targetEntity: Logement::class, inversedBy:'photos')]
    private ?Logement $logement= null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSource(): ?string {
        return $this->source;
    }

     public function setSource(string $source): static {
        $this->source=$source;
        return $this;
    }

     public function getLogement(): ?Logement
    {
        return $this->logement;
    }

    public function setLogement(?Logement $logement): static
    {
        $this->logement = $logement;

        return $this;
    }
}
