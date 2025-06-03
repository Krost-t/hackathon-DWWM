<?php

namespace App\Entity;

use App\Repository\ProduitRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProduitRepository::class)]
class Produit
{
    #[ORM\Id]
    #[ORM\Column(length: 100)]
    private ?string $refProduit = null;

    #[ORM\Column]
    private ?float $prix = null;

    #[ORM\ManyToOne(targetEntity: Type::class, inversedBy: 'produits')]
    #[ORM\JoinColumn(name: 'idType', referencedColumnName: 'id')]
    private ?Type $type = null;

    #[ORM\ManyToOne(targetEntity: Categorie::class, inversedBy: 'produits')]
    #[ORM\JoinColumn(name: 'idCategorie', referencedColumnName: 'id')]
    private ?Categorie $categorie = null;

    #[ORM\OneToMany(mappedBy: 'refProduit', targetEntity: Commander::class, orphanRemoval: true)]
    private Collection $commandes;

    public function __construct()
    {
        $this->commandes = new ArrayCollection();
    }

    public function getRefProduit(): ?string
    {
        return $this->refProduit;
    }

    public function setRefProduit(string $refProduit): static
    {
        $this->refProduit = $refProduit;
        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): static
    {
        $this->prix = $prix;
        return $this;
    }

    public function getType(): ?Type
    {
        return $this->type;
    }

    public function setType(?Type $type): static
    {
        $this->type = $type;
        return $this;
    }

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): static
    {
        $this->categorie = $categorie;
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
            $commande->setRefProduit($this);
        }

        return $this;
    }

    public function removeCommande(Commander $commande): static
    {
        if ($this->commandes->removeElement($commande)) {
            if ($commande->getRefProduit() === $this) {
                $commande->setRefProduit(null);
            }
        }

        return $this;
    }
}
