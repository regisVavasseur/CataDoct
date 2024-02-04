# BUT 3 Informatique - DWM
## Nouveaux Paradigmes de Bases de Données - TD 2

Créez votre environnement pour programmer cette mini application : docker compose comportant un service postgres, un service PHP et un service Adminer. Créez un composer.json installant Doctrine et définissant une racine de namespace : "psr-4" : {"catadoct\catalog\" : "./src/"}

Dans la suite, les différents programmes peuvent être de simples scripts affichant les résultats dans la console. Créez les entités et les associations au fur et à mesure des besoins.

### Participants
- Yvan Quilliard
- Régis Vavasseur

### Préparation
Démarrez les conteneurs avec la commande suivante :
```bash
docker-compose up -d
```

### Exercice 1 : utilisation élémentaire

- Afficher le produit d'identifiant 4 : id, numéro, libellé, description, image.
- Afficher la catégorie 5.
- Compléter le script 1.1 pour afficher la catégorie du produit.
- Afficher tous les produits de la catégorie 5.
- Créer un produit et le relier à la catégorie 5, faire en sorte qu'il soit sauvegardé dans la base.
- Modifier ce produit et mettre à jour la base.
- Supprimer ce produit et mettre à jour la base.

### Exercice 2 : requêtes

- Afficher le produit numéro 4 (requête simple)
- Afficher le produit numéro 5 et de libellé 'Pepperoni' s'il existe (requête simple)
- Afficher la catégorie de libellé 'Boissons' ainsi que les produits de cette catégorie. (requête simple)
- Afficher les produits contenant 'mozzarella' dans leur description (utiliser une requête critères)
- Afficher les produits de la catégorie 5 contenant 'jambon' dans la description (requête critères sur l'association)

### Exercice 3 : Repository et DQL

Traiter les questions qui suivent sous la forme d'une méthode dans un repository dédié à l'entité concernée. Les requêtes seront programmées en DQL.

- Liste des produits d'une catégorie donnée, en incluant les tarifs.
- Liste des produits contenant un mot clé dans le libellé ou la description.
- Liste des produits dont le tarif est inférieur ou égal à un montant donné, ordonnés par numéro ascendant.
- Produit (incluant sa catégorie et son tarif) pour un numéro et une taille donnés.

Cela résume les instructions et les exercices à suivre dans le cadre de ce TD.