<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . '/../../vendor/autoload.php';

use catadoct\catalog\entities\Categorie;
use catadoct\catalog\entities\Produit;
use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Exception\MissingMappingDriverImplementation;
use Doctrine\ORM\Exception\NotSupported;
use Doctrine\ORM\ORMSetup;
use Doctrine\Common\Collections\Criteria;

$entity_path = [__DIR__ . './src/entities/'];
$isDevMode = true;

$dbParams = parse_ini_file(__DIR__ . '/../../db.env');
$config = ORMSetup::createAttributeMetadataConfiguration($entity_path, $isDevMode);

try {
    $connection = DriverManager::getConnection($dbParams, $config);
} catch (\Doctrine\DBAL\Exception $e) {
    echo $e->getMessage();
}

try {
    $entityManager = new EntityManager($connection, $config);
} catch (MissingMappingDriverImplementation $e) {
    echo $e->getMessage();
}

try {
    $categorie = $entityManager->getRepository(Categorie::class)->findOneBy(['libelle' => 'Boissons']);
    $produits = $categorie->getProduits();
    echo json_encode([
        'id' => $categorie->getId(),
        'libellle' => $categorie->getLibelle(),
        'produits' => array_map(function (Produit $produit) {
            return [
                'numero' => $produit->getNumero(),
                'libelle' => $produit->getLibelle(),
                'description' => $produit->getDescription()
            ];
        }, $produits->toArray())

    ]);

} catch (NotSupported $e) {
    echo $e->getMessage();
}