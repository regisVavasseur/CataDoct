<?php

namespace catadoct\catalog\repository;

class ProduitRepository
{
    private $entityManager;

    public function __construct($entityManager) {
        $this->entityManager = $entityManager;
    }

    public function find($id) {
        return $this->entityManager->find('Produit', $id);
    }

}