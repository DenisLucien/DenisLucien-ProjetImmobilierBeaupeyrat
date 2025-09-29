<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    private ?string $email = null;
    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 20)]
    private ?string $username = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

       /**
     * @var Collection<int, Logement>
     */
    #[ORM\OneToMany(targetEntity: Logement::class, mappedBy:'owner')]
    private Collection $ownedLogements;

    /**
     * @var Collection<int, Logement>
     */
    #[ORM\ManyToMany(targetEntity: Logement::class, mappedBy: 'occupants')]
    private Collection $rentals;

    /**
     * @var Collection<int, Demands>
     */
    #[ORM\OneToMany(targetEntity: Demands::class,mappedBy: 'locator', cascade: ['persist', 'remove'])]
    private Collection $demands;

   

    public function __construct()
    {   
        $this->ownedLogements = new ArrayCollection();
        $this->rentals = new ArrayCollection();
        $this->demands= new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Ensure the session doesn't contain actual password hashes by CRC32C-hashing them, as supported since Symfony 7.3.
     */
    public function __serialize(): array
    {
        $data = (array) $this;
        $data["\0".self::class."\0password"] = hash('crc32c', $this->password);

        return $data;
    }

    #[\Deprecated]
    public function eraseCredentials(): void
    {
        // @deprecated, to be removed when upgrading to Symfony 8
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

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


    /**
     * @return Collection<int, Logement>
     */
    public function getOwnedLogements(): Collection
    {
        return $this->ownedLogements;
    }

    public function addOwnedLogement(Logement $ownedLogement): static
    {
        if (!$this->ownedLogements->contains($ownedLogement)) {
            $this->ownedLogements->add($ownedLogement);
            $ownedLogement->setOwner($this);
        }

        return $this;
    }

    public function removeOwnedLogement(Logement $ownedLogement): static
    {
        $this->ownedLogements->removeElement($ownedLogement);
        $ownedLogement->setOwner(null);
        return $this;
    }
    /**
     * @return Collection<int, Logement>
     */
    public function getRentals(): Collection
    {
        return $this->rentals;
    }

    public function addRental(Logement $rental): static
    {
        if (!$this->rentals->contains($rental)) {
            $this->rentals->add($rental);
            $rental->addOccupant($this);
        }

        return $this;
    }

    public function removeRental(Logement $rental): static
    {
        if ($this->rentals->removeElement($rental)) {
            $rental->removeOccupants($this);
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
            $demand->setLocator($this);
        }

        return $this;
    }

    public function removeDemand(Demands $demand): static
    {
        if ($this->demands->removeElement($demand)) {
            if($demand->getLocator()===$this){
                $demand->setLocator(null);
            }
        }

        return $this;
    }
   
}
