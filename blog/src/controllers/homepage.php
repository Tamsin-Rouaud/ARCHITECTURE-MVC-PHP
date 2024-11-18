<?php
// src/controllers/Homepage.php

# =>    Rôle : Gère la logique de la page d'accueil du blog 
# =>    Fonctionnalité : Récupère les derniers billets de blog et les passe à la vue pour les afficher 
# =>    Utilité : Afficher la page d'accueil avec les derniers articles.

// Namespace utilisé pour organiser les classes et éviter les conflits de noms
namespace Application\Controllers\Homepage;

// Inclusion des fichiers nécessaires pour la gestion des articles et la connexion à la base de données
require_once('src/lib/Database.php'); // Gestion de la connexion à la base de données
require_once('src/model/post.php');  // Modèle pour interagir avec les articles

// Utilisation des classes avec leurs namespaces pour simplifier leur appel
use Application\Lib\Database\DatabaseConnection;
use Application\Model\Post\PostRepository;

// Définition de la classe Homepage
class Homepage {

    // Méthode principale pour gérer l'affichage de la page d'accueil
    public function execute() {
        // Instanciation du dépôt des articles (PostRepository) pour interagir avec la base de données
        $postRepository = new PostRepository();
        
        // Attachement d'une connexion à la base de données au dépôt
        $postRepository->connection = new DatabaseConnection();
        
        // Récupération de la liste des articles via le dépôt
        $posts = $postRepository->getPosts();

        // Inclusion de la vue (fichier HTML/PHP) qui affiche les articles
        require('templates/homepage.php');
    }
}
