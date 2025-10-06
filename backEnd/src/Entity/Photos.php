<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\GetCollection;
use App\Repository\PhotosRepository;
use App\State\PhotoProcessor;
use DateTimeImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;

#[ORM\Entity(repositoryClass: PhotosRepository::class)]
#[Vich\Uploadable]
#[ApiResource(
    operations: [
        new Post(
            uriTemplate: '/photos',
            deserialize: false,
            processor: PhotoProcessor::class,
            validationContext: ['groups' => ['Default']],
        ),
        new GetCollection()
    ]
)]
class Photos
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups('logement:read')]
    private ?int $id = null;

    #[Vich\UploadableField(mapping: "photos", fileNameProperty: "source")]
    private ?File $file = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups('logement:read')]
    private ?string $source = null;

    #[ORM\ManyToOne(targetEntity: Logement::class, inversedBy: 'photos')]
    private ?Logement $logement = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE, nullable: true)]
    private ?DateTimeImmutable $updatedAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSource(): ?string
    {
        return $this->source;
    }

    public function setSource(?string $source): static
    {
        $this->source = $source;
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

    public function setFile(?File $file = null): void
    {
        $this->file = $file;
        if ($file) {
            $this->updatedAt = new DateTimeImmutable();
        }
    }

    public function getFile(): ?File
    {
        return $this->file;
    }
}
