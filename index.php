<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . 'vendor/autoload.php';

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

$dbParams = parse_ini_file(__DIR__ . '/db.env');
$config = ORMSetup::createAttributeMetadataConfiguration($entity_path, $isDevMode);

if (!extension_loaded('pdo_pgsql')) {
    die('<p>l\'extention pdo_pgsql n\'est pas installée</p>');
} else {
    echo '<p>l\'extention pdo_pgsql est installée</p>';
}

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
    echo '<br>';
    echo '<p>Exercice 1 : utilisation élémentaire</p>';
    echo '<br>';
    echo '<p>1. afficher le produit d\'identifiant 4 : id, numéro, libellé, description, image.</p>';
    $product = $entityManager->getRepository(Produit::class)->find(4);
    echo '<div style="color: green;"><p>id : ' . $product->getId() . '</p>';
    echo '<p>numéro : ' . $product->getNumero() . '</p>';
    echo '<p>libellé : ' . $product->getLibelle() . '</p>';
    echo '<p>description : ' . $product->getDescription() . '</p></div>';
    echo '<br>';

    echo '<p>2. afficher la catégorie 5.</p>';
    $categorie = $entityManager->getRepository(Categorie::class)->find(5);
    echo '<div style="color: green;"><p>id : ' . $categorie->getId() . '</p>';
    echo '<p>libellé : ' . $categorie->getLibelle() . '</p></div>';
    echo '<br>';

    echo '<p>3. compléter le script 1.1 pour afficher la catégorie du produit.</p>';
    $product = $entityManager->getRepository(Produit::class)->find(4);
    $categorie = $product->getCategorie();
    echo '<div style="color: green;"><p>id : ' . $categorie->getId() . '</p>';
    echo '<p>libellé : ' . $categorie->getLibelle() . '</p></div>';
    echo '<br>';

    echo '<p>4. Afficher tous les produits de la catégorie 5.</p>';
    $categorie = $entityManager->getRepository(Categorie::class)->find(5);
    $produits = $categorie->getProduits();
    foreach ($produits as $produit) {
        echo '<div style="color: green;"><p>id : ' . $produit->getId() . '</p>';
        echo '<p>numéro : ' . $produit->getNumero() . '</p>';
        echo '<p>libellé : ' . $produit->getLibelle() . '</p>';
        echo '<p>description : ' . $produit->getDescription() . '</p></div>';
    }
    echo '<br>';

    echo '<p>5. Créer un produit et le relier à la catégorie 5, faire en sorte qu\'il soit sauvegardé dans la base.</p>';
    $product = new Produit();
    $numero = 100;
    if ($tmpProduct = $entityManager->getRepository(Produit::class)->findOneBy(['numero' => $numero])) {
        echo '<div style="color: red;"><p>Le numéro ' . $numero . ' est déjà utilisé</p></div>';
        echo '<div style="color: cornflowerblue"><p>id : ' . $tmpProduct->getId() . '</p>';
        echo '<p>numéro : ' . $tmpProduct->getNumero() . '</p>';
        echo '<p>libellé : ' . $tmpProduct->getLibelle() . '</p>';
        echo '<p>description : ' . $tmpProduct->getDescription() . '</p>';
        echo '<p>image : ' . $tmpProduct->getImage() . '</p></div>';
    } else {
        $product->setId(1);
        $product->setNumero($numero);
        $product->setLibelle('Produit 1');
        $product->setDescription('Description du produit 1');
        $categorie = $entityManager->getRepository(Categorie::class)->find(5);
        $product->setCategorie($categorie);
        $product->setImage('image1.jpg');
        $entityManager->persist($product);
        $entityManager->flush();
        echo '<div style="color: green;"><p>id : ' . $product->getId() . '</p>';
        echo '<p>numéro : ' . $product->getNumero() . '</p>';
        echo '<p>libellé : ' . $product->getLibelle() . '</p>';
        echo '<p>description : ' . $product->getDescription() . '</p>';
        echo '<p>image : ' . $product->getImage() . '</p></div>';

    }
    echo '<br>';

    echo '<p>6. Modifier ce produit et mettre à jour la base.</p>';
    $product = $entityManager->getRepository(Produit::class)->findOneBy(['numero' => 100]);
    $product->setLibelle('Produit 1 modifié');
    $product->setDescription('Description du produit 1 modifié');
    $entityManager->persist($product);
    $entityManager->flush();
    echo '<div style="color: green;"><p>id : ' . $product->getId() . '</p>';
    echo '<p>numéro : ' . $product->getNumero() . '</p>';
    echo '<p>libellé : ' . $product->getLibelle() . '</p>';
    echo '<p>description : ' . $product->getDescription() . '</p>';
    echo '<p>image : ' . $product->getImage() . '</p></div>';
    echo '<br>';

    echo '<p>7. Supprimer ce produit et mettre à jour la base.</p>';
    $product = $entityManager->getRepository(Produit::class)->findOneBy(['numero' => 100]);
    $entityManager->remove($product);
    $entityManager->flush();
    echo '<div style="color: green;"><p>Le produit a été supprimé</p></div>';
    echo '<br>';

    echo '<br>';
    echo '<p>Exercice 2 : requêtes</p>';
    echo '<br>';
    echo '<p>1. Afficher le produit numéro 4 (requête simple)</p>';
    $product = $entityManager->getRepository(Produit::class)->findOneBy(['numero' => 4]);
    echo '<div style="color: green;"><p>id : ' . $product->getId() . '</p>';
    echo '<p>numéro : ' . $product->getNumero() . '</p>';
    echo '<p>libellé : ' . $product->getLibelle() . '</p>';
    echo '<p>description : ' . $product->getDescription() . '</p>';
    echo '<p>image : ' . $product->getImage() . '</p></div>';
    echo '<br>';

    echo '<p>2. Afficher le produit numéro 5 et de libellé \'Pepperoni\' s\'il existe (requête simple)</p>';
    $product = $entityManager->getRepository(Produit::class)->findOneBy(['numero' => 5, 'libelle' => 'Pepperoni']);
    if ($product) {
        echo '<div style="color: green;"><p>id : ' . $product->getId() . '</p>';
        echo '<p>numéro : ' . $product->getNumero() . '</p>';
        echo '<p>libellé : ' . $product->getLibelle() . '</p>';
        echo '<p>description : ' . $product->getDescription() . '</p>';
        echo '<p>image : ' . $product->getImage() . '</p></div>';
    } else {
        echo '<div style="color: red;"><p>Le produit numéro 5 avec le libellé \'Pepperoni\' n\'existe pas</p></div>';
    }
    echo '<br>';

    echo '<p>3. Afficher la catégorie de libellé \'Boissons\' ainsi que les produits de cette catégorie. (requête simple)</p>';
    $categorie = $entityManager->getRepository(Categorie::class)->findOneBy(['libelle' => 'Boissons']);
    echo '<div style="color: green;"><p>id : ' . $categorie->getId() . '</p>';
    echo '<p>libellé : ' . $categorie->getLibelle() . '</p></div>';
    $produits = $categorie->getProduits();
    foreach ($produits as $produit) {
        echo '<div style="color: green;"><p>id : ' . $produit->getId() . '</p>';
        echo '<p>numéro : ' . $produit->getNumero() . '</p>';
        echo '<p>libellé : ' . $produit->getLibelle() . '</p>';
        echo '<p>description : ' . $produit->getDescription() . '</p></div>';
    }
    echo '<br>';

    echo '<p>4. afficher les produits contenants \'mozzarella\' dans leur description (utiliser une requête critères)</p>';
    $produits = $entityManager->getRepository(Produit::class)->matching(Criteria::create()->where(Criteria::expr()->contains('description', 'mozzarella')));
    foreach ($produits as $produit) {
        echo '<div style="color: green;"><p>id : ' . $produit->getId() . '</p>';
        echo '<p>numéro : ' . $produit->getNumero() . '</p>';
        echo '<p>libellé : ' . $produit->getLibelle() . '</p>';
        echo '<p>description : ' . $produit->getDescription() . '</p></div>';
    }
    echo '<br>';

    echo '<p>5. afficher les produits de la catégorie 5 contenant \'jambon\' dans la description (requête critères sur l\'association)</p>';
    $categorie = $entityManager->getRepository(Categorie::class)->find(5);
    $produits = $categorie->getProduits()->matching(Criteria::create()->where(Criteria::expr()->contains('description', 'jambon')));
    foreach ($produits as $produit) {
        echo '<div style="color: green;"><p>id : ' . $produit->getId() . '</p>';
        echo '<p>numéro : ' . $produit->getNumero() . '</p>';
        echo '<p>libellé : ' . $produit->getLibelle() . '</p>';
        echo '<p>description : ' . $produit->getDescription() . '</p></div>';
    }
    echo '<br>';

    echo '<br>';
    echo '<p>Exercice 3 : Repository et DQL</p>';
    echo '<br>';
    echo '<p>1. Afficher le produit numéro 4 (requête DQL)</p>';
    echo '<p>Traiter les questions qui suivent sous la forme d\'une méthode dans un repository dédié à l\'entité concernée. Les requêtes seront programmées en DQL.</p>';
    echo '<br>';
    echo '<p>1. liste des produits d\'une catégorie donnée, en incluant les tarifs</p>';
    echo 'Pour la catégorie 5, les produits sont :<br>';
    $produits = $entityManager->getRepository(Produit::class)->getProductsByCategoryIncludingTarifs(5);
    foreach ($produits as $produit) {
        echo '<div style="color: green;"><p>id : ' . $produit->getId() . '</p>';
        echo '<p>numéro : ' . $produit->getNumero() . '</p>';
        echo '<p>libellé : ' . $produit->getLibelle() . '</p>';
        echo '<p>description : ' . $produit->getDescription() . '</p></div>';
        $tarifs = $produit->getTarifs();
        foreach ($tarifs as $tarif) {
            echo '<div style="color: green; border: solid 1px black"><p>id : ' . $tarif->getId() . '</p>';
            echo '<p>tarif : ' . $tarif->getTarif() . '</p></div>';
        }
    }
    echo '<br>';

    echo '<p>2. liste des produits contenant un mot clé dans le libellé ou la description</p>';
    $produits = $entityManager->getRepository(Produit::class)->getProductsByKeywordInLabelOrDescription('jambon');
    foreach ($produits as $produit) {
        echo '<div style="color: green;"><p>id : ' . $produit->getId() . '</p>';
        echo '<p>numéro : ' . $produit->getNumero() . '</p>';
        echo '<p>libellé : ' . $produit->getLibelle() . '</p>';
        echo '<p>description : ' . $produit->getDescription() . '</p></div>';
    }
    echo '<br>';

    echo '<p>3. liste des produits dont le tarif est inférieur ou égal à un montant donné, ordonnés par numéro ascendant</p>';
    echo '<p>Nous n\'avons pas réussi à faire fonctionner la méthode getProductsByTarifLessThan</p>';
    echo '<p>Quand j\'appelle la fonction avec un tarif de 12 j\'ai des tarifs >= 13 qui s\'affichent, et si je mets 10 par exemple, j\'ai des tarifs >= 12 qui s\'affichent mais plus ceux qui sont > 13</p>';
    $produits = $entityManager->getRepository(Produit::class)->getProductsByTarifLessThan(10);
    foreach ($produits as $produit) {
        echo '<div style="color: green;"><p>id : ' . $produit->getId() . '</p>';
        echo '<p>numéro : ' . $produit->getNumero() . '</p>';
        echo '<p>libellé : ' . $produit->getLibelle() . '</p>';
        echo '<p>description : ' . $produit->getDescription() . '</p></div>';
        $tarifs = $produit->getTarifs();
        foreach ($tarifs as $tarif) {
            echo '<div style="color: green; border: solid 1px black"><p>id : ' . $tarif->getId() . '</p>';
            echo '<p>tarif : ' . $tarif->getTarif() . '</p></div>';
        }
    }
    echo '<br>';

    echo '<p>4. produit (incluant sa catégorie et son tarif) pour un numéro et une taille donnés.</p>';
    $produits = $entityManager->getRepository(Produit::class)->getProductByNumeroAndSize(2, 'normale');

    foreach ($produits as $produit) {
        echo '<div style="color: green;"><p>id : ' . $produit->getId() . '</p>';
        echo '<p>numéro : ' . $produit->getNumero() . '</p>';
        echo '<p>libellé : ' . $produit->getLibelle() . '</p>';
        echo '<p>description : ' . $produit->getDescription() . '</p></div>';
        $categorie = $produit->getCategorie();
        echo '<div style="color: green;"><p>id : ' . $categorie->getId() . '</p>';
        echo '<p>libellé : ' . $categorie->getLibelle() . '</p></div>';
        $tarifs = $produit->getTarifs();
        foreach ($tarifs as $tarif) {
            echo '<div style="color: green; border: solid 1px black"><p>id : ' . $tarif->getId() . '</p>';
            echo '<p>tarif : ' . $tarif->getTarif() . '</p></div>';
        }
    }



} catch (NotSupported $e) {
    echo $e->getMessage();
}