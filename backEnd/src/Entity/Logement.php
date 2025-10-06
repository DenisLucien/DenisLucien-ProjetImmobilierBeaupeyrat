<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\LogementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: LogementRepository::class)]
#[ApiResource()]
class Logement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups('logement:read')]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups('logement:read')]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    private ?string $address = null;

    #[ORM\Column(length: 50)]
    private ?string $status = null;

    /**
     * @var Collection<int, Photos>
     */
    #[ORM\OneToMany(targetEntity: Photos::class, mappedBy: 'logement', orphanRemoval: true)]
    #[Groups('logement:read')]
    private Collection $photos;

    #[ORM\Column]
    #[Gedmo\Timestampable(on: 'create')]
    private ?\DateTimeImmutable $created_at = null;


    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'ownedLogements')]
    private ?User $owner = null;

    /**
     * @var Collection<int, User>
     */
    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'rentals')]
    private Collection $occupants;

    /**
     * @var Collection<int, Demands>
     */
    #[ORM\OneToMany(targetEntity: Demands::class, mappedBy: 'logement', orphanRemoval: true)]
    private Collection $demands;

    public function __construct()
    {
        $this->occupants = new ArrayCollection();
        $this->demands = new ArrayCollection();
        $this->photos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): static
    {
        $this->address = $address;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): static
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function setOwner(?User $owner): static
    {
        $this->owner = $owner;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getOccupants(): Collection
    {
        return $this->occupants;
    }

    public function addOccupant(User $occupantId): static
    {
        if (!$this->occupants->contains($occupantId)) {
            $this->occupants->add($occupantId);
        }

        return $this;
    }

    public function removeOccupants(User $occupantId): static
    {
        $this->occupants->removeElement($occupantId);

        return $this;
    }


    /**
     * @return Collection<int, Photos>
     */
    public function getPhotos(): Collection
    {
        return $this->photos;
    }

    public function addPhoto(Photos $photo): static
    {
        if (!$this->photos->contains($photo)) {
            $this->photos->add($photo);
            $photo->setLogement($this);
        }

        return $this;
    }

    public function removePhoto(Photos $photo): static
    {
        if ($this->photos->removeElement($photo)) {
            // set the owning side to null (unless already changed)
            if ($photo->getSource() === $this) {
                $photo->setLogement(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Demands>
     */
    public function getDemands(): Collection
    {
        return $this->demands;
    }

    public function addDemand(Demands $demand): static
    {
        if (!$this->demands->contains($demand)) {
            $this->demands->add($demand);
            $demand->setLogement($this);
        }

        return $this;
    }

    public function removeDemand(Demands $demand): static
    {
        if ($this->demands->removeElement($demand)) {
            // set the owning side to null (unless already changed)
            if ($demand->getLogement() === $this) {
                $demand->setLogement(null);
            }
        }

        return $this;
    }
}
