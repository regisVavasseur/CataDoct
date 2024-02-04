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
    $product = new Produit();
    $numero = 100;
    if ($tmp = $entityManager->getRepository(Produit::class)->findOneBy(['numero' => $numero])) {
        echo 'Produit déjà existant';
    } else {
        $product->setId(100);
        $product->setNumero($numero);
        $product->setLibelle('Produit 100');
        $product->setDescription('Description du produit 100');
        $product->setImage('image100.jpg');
        $categorie = $entityManager->getRepository(Categorie::class)->find(5);
        $product->setCategorie($categorie);
        $entityManager->persist($product);
        $entityManager->flush();
        echo json_encode([
            'id' => $product->getId(),
            'numero' => $product->getNumero(),
            'libelle' => $product->getLibelle(),
            'description' => $product->getDescription(),
            'image' => $product->getImage(),
            'categorie' => [
                'id' => $categorie->getId(),
                'libelle' => $categorie->getLibelle(),
            ],
        ]);
    }

} catch (NotSupported $e) {
    echo $e->getMessage();
}