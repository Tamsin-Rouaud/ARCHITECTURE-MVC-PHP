<?php

// Inclusion des fichiers nécessaires (les contrôleurs pour la page d'accueil, les billets et l'ajout de commentaires)
require_once('src/controllers/homepage.php');
require_once('src/controllers/post.php');
require_once('src/controllers/add_comment.php');

// Utilisation des espaces de noms pour les contrôleurs
use Application\Controllers\AddComment\AddComment;
use Application\Controllers\Homepage\Homepage;
use Application\Controllers\Post\Post;

// Structure try-catch pour gérer les erreurs
try {
    // Vérifie si l'action est spécifiée dans l'URL
    if (isset($_GET['action']) && $_GET['action'] !== '') {
        // Si l'action est 'post', affiche le billet demandé
        if ($_GET['action'] === 'post') {
            // Vérifie si l'ID du billet est bien défini et positif
            if (isset($_GET['id']) && $_GET['id'] > 0) {
                $identifier = $_GET['id'];  // Récupère l'ID du billet
                (new Post())->execute($identifier);  // Exécute le contrôleur 'Post' pour afficher le billet
            } else {
                throw new Exception("aucun identifiant de billet envoyé");  // Lève une exception si l'ID est manquant ou invalide
            }
        } 
        // Si l'action est 'addComment', ajoute un commentaire
        elseif ($_GET['action'] === 'addComment') {
            // Vérifie si l'ID du billet est bien défini et positif
            if (isset($_GET['id']) && $_GET['id'] > 0) {
                $identifier = $_GET['id'];  // Récupère l'ID du billet
                (new AddComment())->execute($identifier, $_POST);  // Exécute le contrôleur 'AddComment' pour ajouter un commentaire
            } else {
                throw new Exception("aucun identifiant de billet envoyé");  // Lève une exception si l'ID est manquant ou invalide
            }
        } else {
            throw new Exception("La page que vous recherchez n'existe pas.");  // Lève une exception si l'action est inconnue
        }
    } else {
        // Si aucune action n'est spécifiée, affiche la page d'accueil avec la liste des derniers billets
        (new Homepage())->execute();
    }
} catch(Exception $e) {
    // Si une exception est levée, affiche un message d'erreur
    $errorMessage = $e->getMessage();

    // Inclut le fichier de template pour afficher l'erreur
    require('templates/error.php');
}


