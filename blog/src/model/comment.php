<?php
// src/model/comment.php

// Namespace pour organiser les classes du modèle dédié aux commentaires
namespace Application\Model\Comment;

// Inclusion de la classe de connexion à la base de données
require_once('src/lib/database.php');

// Utilisation de la classe `DatabaseConnection` définie dans le namespace correspondant
use Application\Lib\Database\DatabaseConnection;

// Définition de la classe Comment qui représente un commentaire individuel
class Comment {
    // Propriétés de la classe pour stocker les données d'un commentaire
    public string $author;                // Auteur du commentaire
    public string $frenchCreationDate;    // Date de création formatée (en français)
    public string $comment;               // Contenu du commentaire
}

// Définition de la classe CommentRepository pour gérer les opérations sur les commentaires dans la base de données
class CommentRepository {
    // Propriété pour stocker l'objet de connexion à la base de données
    public DatabaseConnection $connection;

    // Méthode pour récupérer les commentaires associés à un article
    public function getComments(string $identifier): array {
        // Préparation de la requête SQL pour sélectionner les commentaires d'un article donné
        $statement = $this->connection->getConnection()->prepare(
            "SELECT 
                id, 
                author, 
                comment, 
                DATE_FORMAT(comment_date, '%d/%m/%Y à %Hh%imin%ss') AS french_creation_date 
             FROM comments 
             WHERE post_id = ? 
             ORDER BY comment_date DESC"
        );

        // Exécution de la requête avec l'identifiant de l'article
        $statement->execute([$identifier]);

        // Initialisation d'un tableau pour stocker les objets Comment
        $comments = [];
        // Parcours des résultats et création d'objets Comment pour chaque commentaire
        while (($row = $statement->fetch())) {
            $comment = new Comment();
            $comment->author = $row['author'];                     // Auteur du commentaire
            $comment->frenchCreationDate = $row['french_creation_date']; // Date formatée
            $comment->comment = $row['comment'];                   // Contenu du commentaire
            $comments[] = $comment;                                // Ajout au tableau des commentaires
        }

        // Retourne le tableau de commentaires
        return $comments;
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
}
