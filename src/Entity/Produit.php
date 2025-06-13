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

    #[ORM\Column(length: 150)]
    private ?string $nomProduit = null;

    #[ORM\Column]
    private ?float $prix = null;

    /**
     * @var Collection<int, Commande>
     */
    #[ORM\OneToMany(targetEntity: Commande::class, mappedBy: 'commandeProduit')]
    private Collection $commandes;

    /**
     * @var Collection<int, Livraison>
     */
    #[ORM\OneToMany(targetEntity: Livraison::class, mappedBy: 'livraisonProduit')]
    private Collection $livraisons;

    /**
     * @var Collection<int, Categorie>
     */
    #[ORM\OneToMany(targetEntity: Categorie::class, mappedBy: 'produit')]
    private Collection $categorieProduit;

    #[ORM\ManyToOne(inversedBy: 'produits')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Type $typeProduit = null;

    public function __construct()
    {
        $this->commandes = new ArrayCollection();
        $this->livraisons = new ArrayCollection();
        $this->categorieProduit = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): static
    {
        $this->prix = $prix;

        return $this;
    }

    /**
     * @return Collection<int, Commande>
     */
    public function getCommandes(): Collection
    {
        return $this->commandes;
    }

    public function addCommande(Commande $commande): static
    {
        if (!$this->commandes->contains($commande)) {
            $this->commandes->add($commande);
            $commande->setCommandeProduit($this);
        }

        return $this;
    }

    public function removeCommande(Commande $commande): static
    {
        if ($this->commandes->removeElement($commande)) {
            // set the owning side to null (unless already changed)
            if ($commande->getCommandeProduit() === $this) {
                $commande->setCommandeProduit(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Livraison>
     */
    public function getLivraisons(): Collection
    {
        return $this->livraisons;
    }

    public function addLivraison(Livraison $livraison): static
    {
        if (!$this->livraisons->contains($livraison)) {
            $this->livraisons->add($livraison);
            $livraison->setLivraisonProduit($this);
        }

        return $this;
    }

    public function removeLivraison(Livraison $livraison): static
    {
        if ($this->livraisons->removeElement($livraison)) {
            // set the owning side to null (unless already changed)
            if ($livraison->getLivraisonProduit() === $this) {
                $livraison->setLivraisonProduit(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Categorie>
     */
    public function getCategorieProduit(): Collection
    {
        return $this->categorieProduit;
    }

    public function addCategorieProduit(Categorie $categorieProduit): static
    {
        if (!$this->categorieProduit->contains($categorieProduit)) {
            $this->categorieProduit->add($categorieProduit);
            $categorieProduit->setProduit($this);
        }

        return $this;
    }

    public function removeCategorieProduit(Categorie $categorieProduit): static
    {
        if ($this->categorieProduit->removeElement($categorieProduit)) {
            // set the owning side to null (unless already changed)
            if ($categorieProduit->getProduit() === $this) {
                $categorieProduit->setProduit(null);
            }
        }

        return $this;
    }

    public function getTypeProduit(): ?Type
    {
        return $this->typeProduit;
    }

    public function setTypeProduit(?Type $typeProduit): static
    {
        $this->typeProduit = $typeProduit;

        return $this;
    }
}
