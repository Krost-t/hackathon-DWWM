<?php

namespace App\Entity;

use App\Repository\AdresseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AdresseRepository::class)]
class Adresse
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nomRue = null;

    #[ORM\Column(length: 255)]
    private ?string $numRue = null;

    #[ORM\Column(length: 255)]
    private ?string $ville = null;

    #[ORM\Column(length: 255)]
    private ?string $pays = null;

    #[ORM\Column(length: 255)]
    private ?string $codepstl = null;

    /**
     * @var Collection<int, Produit>
     */
    #[ORM\OneToMany(targetEntity: Produit::class, mappedBy: 'adresse')]
    private Collection $refProduit;

    public function __construct()
    {
        $this->refProduit = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomRue(): ?string
    {
        return $this->nomRue;
    }

    public function setNomRue(string $nomRue): static
    {
        $this->nomRue = $nomRue;

        return $this;
    }

    public function getNumRue(): ?string
    {
        return $this->numRue;
    }

    public function setNumRue(string $numRue): static
    {
        $this->numRue = $numRue;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): static
    {
        $this->ville = $ville;

        return $this;
    }

    public function getPays(): ?string
    {
        return $this->pays;
    }

    public function setPays(string $pays): static
    {
        $this->pays = $pays;

        return $this;
    }

    public function getCodepstl(): ?string
    {
        return $this->codepstl;
    }

    public function setCodepstl(string $codepstl): static
    {
        $this->codepstl = $codepstl;

        return $this;
    }

    /**
     * @return Collection<int, Produit>
     */
    public function getRefProduit(): Collection
    {
        return $this->refProduit;
    }

    public function addRefProduit(Produit $refProduit): static
    {
        if (!$this->refProduit->contains($refProduit)) {
            $this->refProduit->add($refProduit);
            $refProduit->setAdresse($this);
        }

        return $this;
    }

    public function removeRefProduit(Produit $refProduit): static
    {
        if ($this->refProduit->removeElement($refProduit)) {
            // set the owning side to null (unless already changed)
            if ($refProduit->getAdresse() === $this) {
                $refProduit->setAdresse(null);
            }
        }

        return $this;
    }
}
