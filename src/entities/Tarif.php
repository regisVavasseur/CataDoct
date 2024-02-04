<?php

namespace catadoct\catalog\entities;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: "tarif")]
class Tarif
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'float')]
    private float $tarif;

    #[ORM\ManyToOne(targetEntity: Produit::class)]
    #[ORM\JoinColumn(name: 'produit_id', referencedColumnName: 'id')]
    private Produit $produit;

    #[ORM\ManyToOne(targetEntity: Taille::class)]
    #[ORM\JoinColumn(name: 'taille_id', referencedColumnName: 'id')]
    private Taille $taille;

    public function getId(): int
    {
        return $this->id;
    }

    public function getTaille(): Taille
    {
        return $this->taille;
    }

    public function setTaille(Taille $taille): void
    {
        $this->taille = $taille;
    }

    public function getTarif(): float
    {
        return $this->tarif;
    }

    public function setTarif(float $tarif): void
    {
        $this->tarif = $tarif;
    }

    public function getProduit(): Produit
    {
        return $this->produit;
    }

    public function setProduit(Produit $produit): void
    {
        $this->produit = $produit;
    }
}