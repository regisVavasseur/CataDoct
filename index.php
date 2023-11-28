<?php

require_once __DIR__ . DIRECTORY_SEPARATOR .'vendor/autoload.php';

use catadoct\catalog\entities\Produit;
use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Exception\MissingMappingDriverImplementation;
use Doctrine\ORM\Exception\NotSupported;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\ORMSetup;

$entity_path = [ __DIR__ . './src/entities/'];
$isDevMode = true;

$dbParams = parse_ini_file(__DIR__ . './db.env');

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

$product = new Produit();

try {
    $entityManager->persist($product);
} catch (ORMException $e) {
    echo $e->getMessage();
}

try {
    print_r($entityManager->getRepository(Produit::class)->find(4));
} catch (NotSupported $e) {
    echo $e->getMessage();
}