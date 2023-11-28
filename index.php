<?php

require_once __DIR__ . DIRECTORY_SEPARATOR .'vendor/autoload.php';

use catadoct\catalog\entities\Produit;
use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;

$entity_path = [ __DIR__ . './src/entities/'];
$isDevMode = true;

$dbParams = parse_ini_file(__DIR__ . './db.env');

$config = ORMSetup::createAttributeMetadataConfiguration($entity_path, $isDevMode);
$connection = DriverManager::getConnection($dbParams, $config);
$entityManager = new EntityManager($connection, $config);

$product = new Produit();
$entityManager->persist($product);

print_r($entityManager->getRepository(Produit::class)->findAll());


