<?php

namespace App\Entity;

use App\Repository\CommanderRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommanderRepository::class)]
class Commander
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'commandes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $idClient = null;

    #[ORM\ManyToOne(targetEntity: Produit::class, inversedBy: 'commandes')]
    #[ORM\JoinColumn(name: 'refProduit', referencedColumnName: 'refProduit', nullable: false)]
    private ?Produit $refProduit = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdClient(): ?User
    {
        return $this->idClient;
    }

    public function setIdClient(?User $idClient): static
    {
        $this->idClient = $idClient;
        return $this;
    }

    public function getRefProduit(): ?Produit
    {
        return $this->refProduit;
    }

    public function setRefProduit(?Produit $refProduit): static
    {
        $this->refProduit = $refProduit;
        return $this;
    }
}
