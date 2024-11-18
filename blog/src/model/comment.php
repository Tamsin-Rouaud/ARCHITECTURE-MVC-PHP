<?php
// src/model/Comment.php

# =>    Rôle : Modélise un commentaire dans l'application
# =>    Fonctionnalité : Définit la structure d'un commentaire (auteur, date, contenu) / Contient un COmmentRepository qui permet d'interagir avec la base de données pour récupérer et créer  des commentaires.
# =>    Utilité : Gère les données et la logique métier concernant les commentaires (récupérer, ajouter)

// Namespace pour organiser les classes du modèle dédié aux commentaires
namespace Application\Model\Comment;

// Inclusion de la classe de connexion à la base de données
require_once('src/lib/Database.php');

// Utilisation de la classe `DatabaseConnection` définie dans le namespace correspondant
use Application\Lib\Database\DatabaseConnection;

// Définition de la classe Comment qui représente un commentaire individuel
class Comment {
    // Propriétés de la classe pour stocker les données d'un commentaire
    
    public string $identifier;
    public string $author;                // Auteur du commentaire
    public string $frenchCreationDate;    // Date de création formatée (en français)
    public string $comment;               // Contenu du commentaire
    public string $post;
}

// Définition de la classe CommentRepository pour gérer les opérations sur les commentaires dans la base de données
class CommentRepository {
    // Propriété pour stocker l'objet de connexion à la base de données
    public DatabaseConnection $connection;

    // Méthode pour récupérer les commentaires associés à un article
    public function getComments(string $post): array {
        // Préparation de la requête SQL pour sélectionner les commentaires d'un article donné
        $statement = $this->connection->getConnection()->prepare(
            "SELECT 
                id, 
                author, 
                comment, 
                DATE_FORMAT(comment_date, '%d/%m/%Y à %Hh%imin%ss') AS french_creation_date, post_id 
             FROM comments 
             WHERE post_id = ? 
             ORDER BY comment_date DESC"
        );

        // Exécution de la requête avec l'identifiant de l'article
        $statement->execute([$post]);

        // Initialisation d'un tableau pour stocker les objets Comment
        $comments = [];
        // Parcours des résultats et création d'objets Comment pour chaque commentaire
        while (($row = $statement->fetch())) {
            $comment = new Comment();
            $comment->identifier = $row['id'];
            $comment->author = $row['author'];                     // Auteur du commentaire
            $comment->frenchCreationDate = $row['french_creation_date']; // Date formatée
            $comment->comment = $row['comment'];                   // Contenu du commentaire
            $comment->post = $row['post_id'];
            $comments[] = $comment;                                // Ajout au tableau des commentaires
        }

        // Retourne le tableau de commentaires
        return $comments;
    }

    public function getComment(string $identifier): ?Comment {
        //Prépare une requête SQL pour récupérer le commentaire correspondant à l'identifiant
        $statement = $this->connection->getConnection()->prepare(
            "SELECT
            id,
            author,
            comment,
            DATE_FORMAT(comment_date, '%d/%m/%Y à %Hh%imin%ss') AS
            french_creation_date, post_id
            FROM comments
            WHERE id = ?"
        );

        //Exécute la requête en passant l'identifiant comme paramètre
        $statement->execute([$identifier]);

        //Récupère la ligne correspondante
        $row = $statement->fetch();

        //Création d'un objet `Comment` pour stocker les données du commentaire
        $comment = new Comment();
        $comment->identifier = $row['id'];
        $comment->author = $row['author'];
        $comment->frenchCreationDate = $row['french_creation_date'];
        $comment->comment = $row['comment'];
        $comment->post = $row['post_id'];
        
        return $comment;
        

    }

    // Méthode pour ajouter un commentaire à un article
    public function createComment(string $post, string $author, string $comment): bool {
        // Préparation de la requête SQL pour insérer un nouveau commentaire
        $statement = $this->connection->getConnection()->prepare(
            "INSERT INTO comments(post_id, author, comment, comment_date) 
             VALUES(?, ?, ?, NOW())"
        );

        // Exécution de la requête avec les données fournies
        $affectedLines = $statement->execute([$post, $author, $comment]);

        // Retourne `true` si une ligne a été insérée, sinon `false`
        return ($affectedLines > 0);
    }

    public function updateComment(string $identifier, string $author, string $comment): bool {
        $statement = $this->connection->getConnection()->prepare(
            "UPDATE comments SET author = ?, comment = ? WHERE id = ?"
        );
        $affectedLines = $statement->execute([$author, $comment, $identifier]);

        return ($affectedLines > 0);
    }
}
