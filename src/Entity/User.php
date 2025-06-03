<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Entity\Commander;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column]
    private bool $isVerified = false;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nom = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $prenom = null;

    #[ORM\Column(nullable: true)]
    private ?int $age = null;

    #[ORM\ManyToOne(targetEntity: Adresse::class, inversedBy: 'users')]
    #[ORM\JoinColumn(name: 'adresse_id', referencedColumnName: 'id')]
    private ?Adresse $adresse = null;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Commander::class, orphanRemoval: true)]
    private Collection $commandes;

    /**
     * @var Collection<int, Commander>
     */
    #[ORM\OneToMany(targetEntity: Commander::class, mappedBy: 'idClient')]
    private Collection $commanders;

    public function __construct()
    {
        $this->commandes = new ArrayCollection();
        $this->commanders = new ArrayCollection();
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

    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles[] = 'ROLE_USER';
        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;
        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;
        return $this;
    }

    public function eraseCredentials(): void {}

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): static
    {
        $this->isVerified = $isVerified;
        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): static
    {
        $this->nom = $nom;
        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(?string $prenom): static
    {
        $this->prenom = $prenom;
        return $this;
    }

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(?int $age): static
    {
        $this->age = $age;
        return $this;
    }

    public function getAdresse(): ?Adresse
    {
        return $this->adresse;
    }

    public function setAdresse(?Adresse $adresse): static
    {
        $this->adresse = $adresse;
        return $this;
    }

    /**
     * @return Collection<int, Commander>
     */
    public function getCommandes(): Collection
    {
        return $this->commandes;
    }

    public function addCommande(Commander $commande): static
    {
        if (!$this->commandes->contains($commande)) {
            $this->commandes[] = $commande;
            $commande->setUser($this);
        }

        return $this;
    }

    public function removeCommande(Commander $commande): static
    {
        if ($this->commandes->removeElement($commande)) {
            if ($commande->getUser() === $this) {
                $commande->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Commander>
     */
    public function getCommanders(): Collection
    {
        return $this->commanders;
    }

    public function addCommander(Commander $commander): static
    {
        if (!$this->commanders->contains($commander)) {
            $this->commanders->add($commander);
            $commander->setIdClient($this);
        }

        return $this;
    }

    public function removeCommander(Commander $commander): static
    {
        if ($this->commanders->removeElement($commander)) {
            // set the owning side to null (unless already changed)
            if ($commander->getIdClient() === $this) {
                $commander->setIdClient(null);
            }
        }

        return $this;
    }
}
