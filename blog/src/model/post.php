<?php
// src/model/Post.php

# =>    Rôle : Modélise un billet de blog 
# =>    Fonctionnalité : Définit la structure d'un billet (titre, contenu, date de création) / COntient un PostRepository qui permet d'interagir avec la base de données pour récupérer les billets de blog
# =>    Utilité : Gère les données et la logique métier concernant les billets de blogs (récupérer, afficher)

// Déclaration du namespace pour organiser les classes liées aux articles (posts)
namespace Application\Model\Post;

// Inclusion de la classe de connexion à la base de données
require_once('src/lib/Database.php');

// Utilisation de la classe `DatabaseConnection` du namespace correspondant
use Application\Lib\Database\DatabaseConnection;

// Définition de la classe `Post` qui représente un article individuel
class Post {
    // Propriétés de la classe pour stocker les informations d'un article
    public string $title;               // Titre de l'article
    public string $frenchCreationDate;  // Date de création formatée en français
    public string $content;             // Contenu de l'article
    public string $identifier;          // Identifiant unique de l'article
}

// Définition de la classe `PostRepository` pour gérer les interactions avec la table `posts`
class PostRepository {
    // Propriété pour stocker l'objet de connexion à la base de données
    public DatabaseConnection $connection;

    // Méthode pour récupérer un article spécifique à partir de son identifiant
    public function getPost(string $identifier): Post {
        // Prépare une requête SQL pour récupérer l'article correspondant à l'identifiant
        $statement = $this->connection->getConnection()->prepare(
            "SELECT 
                id, 
                title, 
                content, 
                DATE_FORMAT(creation_date, '%d/%m/%Y à %Hh%imin%ss') AS french_creation_date 
             FROM posts 
             WHERE id = ?"
        );

        // Exécute la requête en passant l'identifiant comme paramètre
        $statement->execute([$identifier]);

        // Récupère la ligne correspondante
        $row = $statement->fetch();

        // Création d'un objet `Post` pour stocker les données de l'article
        $post = new Post();
        $post->title = $row['title'];                     // Titre de l'article
        $post->frenchCreationDate = $row['french_creation_date']; // Date formatée
        $post->content = $row['content'];                 // Contenu
        $post->identifier = $row['id'];                   // Identifiant unique

        // Retourne l'objet `Post`
        return $post;
    }

    // Méthode pour récupérer les 5 derniers articles de la base de données
    public function getPosts(): array {
        // Exécution d'une requête SQL pour sélectionner les 5 articles les plus récents
        $statement = $this->connection->getConnection()->query(
            "SELECT 
                id, 
                title, 
                content, 
                DATE_FORMAT(creation_date, '%d/%m/%Y à %Hh%imin%ss') AS french_creation_date 
             FROM posts 
             ORDER BY creation_date DESC 
             LIMIT 0, 5"
        );

        // Initialisation d'un tableau pour stocker les objets `Post`
        $posts = [];
        // Parcours des résultats et création d'objets `Post` pour chaque ligne
        while ($row = $statement->fetch()) {
            $post = new Post();
            $post->title = $row['title'];                     // Titre de l'article
            $post->frenchCreationDate = $row['french_creation_date']; // Date formatée
            $post->content = $row['content'];                 // Contenu
            $post->identifier = $row['id'];                   // Identifiant unique

            $posts[] = $post; // Ajout de l'objet au tableau des articles
        }

        // Retourne le tableau d'articles
        return $posts;
    }
}
