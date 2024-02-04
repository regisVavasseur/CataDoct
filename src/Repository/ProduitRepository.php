<?php

namespace catadoct\catalog\Repository;

use Doctrine\ORM\EntityRepository;

class ProduitRepository extends EntityRepository
{

    public function getProductsByCategoryIncludingTarifs(int $categoryId): array
    {
        $query = $this->getEntityManager()->createQuery(
            'SELECT p, t FROM catadoct\catalog\entities\Produit p
            JOIN p.tarifs t
            WHERE p.categorie = :categoryId'
        )->setParameter('categoryId', $categoryId);

        return $query->getResult();
    }

    public function getProductsByKeywordInLabelOrDescription(string $keyword): array
    {
        $query = $this->getEntityManager()->createQuery(
            'SELECT p FROM catadoct\catalog\entities\Produit p
            WHERE p.libelle LIKE :keyword
            OR p.description LIKE :keyword'
        )->setParameter('keyword', "%$keyword%");

        return $query->getResult();
    }

    //Je n'ai pas compris pourquoi ma méthode getProductsByTarifLessThan ne fonctionne pas
    //Quand j'appelle la fonction avec un tarif de 12 j'ai des tarifs >= 13 qui s'affichent, et si je mets 10 par exemple, j'ai des tarifs >= 12 qui s'affichent mais plus ceux qui sont > 13
    public function getProductsByTarifLessThan(float $tarif): array
    {
        $query = $this->getEntityManager()->createQuery(
            'SELECT p, t FROM catadoct\catalog\entities\Produit p
            JOIN p.tarifs t
            WHERE t.tarif <= :tarif'
        )->setParameter('tarif', $tarif);

        return $query->getResult();
    }

    //Créer une fonction qui récupère le produit (incluant sa catégorie et son tarif) via son un numéro et une taille donnés.
    public function getProductByNumeroAndSize(int $numero, string $size): array
    {
        $query = $this->getEntityManager()->createQuery(
            'SELECT p, t, c FROM catadoct\catalog\entities\Produit p
        JOIN p.tarifs t
        JOIN p.categorie c
        JOIN t.taille ta
        WHERE p.numero = :numero AND ta.libelle = :size'
        )->setParameters(['numero' => $numero, 'size' => $size]);

        return $query->getResult();
    }

}