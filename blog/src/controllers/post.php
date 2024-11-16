<?php
// controllers/post.php

// Namespace utilisé pour organiser les classes et éviter les conflits de noms
namespace Application\Controllers\Post;

// Inclusion des fichiers nécessaires pour gérer les articles, les commentaires et la base de données
require_once('src/lib/database.php');  // Classe pour la connexion à la base de données
require_once('src/model/post.php');   // Modèle pour les articles
require_once('src/model/comment.php'); // Modèle pour les commentaires

// Utilisation des classes avec leurs namespaces
use Application\Lib\Database\DatabaseConnection;
use Application\Model\Post\PostRepository;
use Application\Model\Comment\CommentRepository;

// Définition de la classe Post
class Post {
    // Méthode principale qui gère l'affichage d'un article et de ses commentaires
    public function execute(string $identifier) {
        // Création d'une connexion à la base de données
        $connection = new DatabaseConnection();

        // --- Gestion de l'article ---
        // Instanciation du dépôt d'articles
        $postRepository = new PostRepository();
        // Association de la connexion à la base de données au dépôt
        $postRepository->connection = $connection;
        // Récupération de l'article correspondant à l'identifiant donné
        $post = $postRepository->getPost($identifier);

        // --- Gestion des commentaires ---
        // Instanciation du dépôt des commentaires
        $commentRepository = new CommentRepository();
        // Association de la connexion à la base de données au dépôt
        $commentRepository->connection = $connection;
        // Récupération des commentaires associés à l'article
        $comments = $commentRepository->getComments($identifier);

        // Inclusion de la vue pour afficher l'article et ses commentaires
        require('templates/post.php');
    }
}
