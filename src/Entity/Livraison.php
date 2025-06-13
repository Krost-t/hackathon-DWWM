<?php

namespace App\Entity;

use App\Repository\LivraisonRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LivraisonRepository::class)]
class Livraison
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIMETZ_IMMUTABLE)]
    private ?\DateTimeImmutable $dateLivraison = null;

    #[ORM\ManyToOne(inversedBy: 'livraisons')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Adresse $livraisonAdresse = null;

    #[ORM\ManyToOne(inversedBy: 'livraisons')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Produit $livraisonProduit = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateLivraison(): ?\DateTimeImmutable
    {
        return $this->dateLivraison;
    }

    public function setDateLivraison(\DateTimeImmutable $dateLivraison): static
    {
        $this->dateLivraison = $dateLivraison;

        return $this;
    }

    public function getLivraisonAdresse(): ?Adresse
    {
        return $this->livraisonAdresse;
    }

    public function setLivraisonAdresse(?Adresse $livraisonAdresse): static
    {
        $this->livraisonAdresse = $livraisonAdresse;

        return $this;
    }

    public function getLivraisonProduit(): ?Produit
    {
        return $this->livraisonProduit;
    }

    public function setLivraisonProduit(?Produit $livraisonProduit): static
    {
        $this->livraisonProduit = $livraisonProduit;

        return $this;
    }
}
