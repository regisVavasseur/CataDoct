<?php

namespace catadoct\catalog\entities;

use catadoct\catalog\Repository\ProduitRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

//#[ORM\Entity]
#[ORM\Entity(repositoryClass: ProduitRepository::class)]
#[ORM\Table(name: "produit")]
class Produit
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'integer')]
    private int $numero;

    #[ORM\Column(type: 'string')]
    private string $libelle;

    #[ORM\Column(type: 'text')]
    private string $description;

    #[ORM\Column(type: 'string')]
    private string $image;

    #[ORM\ManyToOne(targetEntity: Categorie::class)]
    #[ORM\JoinColumn(name: 'categorie_id', referencedColumnName: 'id')]
    private Categorie $categorie;

    #[ORM\OneToMany(mappedBy: 'produit', targetEntity: Tarif::class)]
    private Collection $tarifs;

    public function getTarifs(): Collection
    {
        return $this->tarifs;
    }

    public function setTarifs(Collection $tarifs): void
    {
        $this->tarifs = $tarifs;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getNumero(): int
    {
        return $this->numero;
    }

    public function setNumero(int $numero): void
    {
        $this->numero = $numero;
    }

    public function getLibelle(): string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): void
    {
        $this->libelle = $libelle;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getImage(): string
    {
        return $this->image;
    }

    public function setImage(string $image): void
    {
        $this->image = $image;
    }

    public function getCategorie(): Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(Categorie $categorie): void
    {
        $this->categorie = $categorie;
    }
}