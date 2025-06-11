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
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100, unique: true)]
    private ?string $refProduit = null;

    #[ORM\Column(length: 255)]
    private ?string $nomProduit = null;

    #[ORM\Column(type: "text", nullable: true)]
    private ?string $description = null;

    #[ORM\Column]
    private ?float $prix = null;

    #[ORM\ManyToOne(targetEntity: Type::class, inversedBy: 'produits')]
    #[ORM\JoinColumn(name: 'idType', referencedColumnName: 'id')]
    private ?Type $type = null;

    #[ORM\ManyToOne(targetEntity: Categorie::class, inversedBy: 'produits')]
    #[ORM\JoinColumn(name: 'idCategorie', referencedColumnName: 'id')]
    private ?Categorie $categorie = null;

    #[ORM\OneToMany(mappedBy: 'produit', targetEntity: Commander::class, orphanRemoval: true)]
    private Collection $commandes;

    #[ORM\OneToOne(mappedBy: 'produit', targetEntity: ImageProduit::class, cascade: ['persist', 'remove'])]
    private ?ImageProduit $image = null;

    public function __construct()
    {
        $this->commandes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getNomProduit(): ?string
    {
        return $this->nomProduit;
    }

    public function setNomProduit(string $nomProduit): static
    {
        $this->nomProduit = $nomProduit;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;
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
            $commande->setProduit($this);
        }

        return $this;
    }

    public function removeCommande(Commander $commande): static
    {
        if ($this->commandes->removeElement($commande)) {
            if ($commande->getProduit() === $this) {
                $commande->setProduit(null);
            }
        }

        return $this;
    }

    public function getImage(): ?ImageProduit
    {
        return $this->image;
    }

    public function setImage(?ImageProduit $image): static
    {
        $this->image = $image;
        return $this;
    }
}
