<?php
// src/index.php

# =>    Rôle : Fichier principal / Routeur
# =>    Fonctionnalité : Intercepte les requêtes utilisateur, décide quelle action (page) doit être effectuée en fonction des paramètres dans l'URL (action, id, etc.) / Utilise les contrôleurs pour afficher les pages demandées ou gérer les erreurs
# =>    Utilité : Point d'entrée de l'application, fait le lien entre la logique métier et l'affichage des vues.

// Inclusion des fichiers nécessaires (les contrôleurs pour la page d'accueil, les billets et l'ajout de commentaires)
require_once('src/controllers/Homepage.php');
require_once('src/controllers/Post.php');
require_once('src/controllers/comment/AddComment.php');
require_once('src/controllers/comment/UpdateComment.php');

// Utilisation des espaces de noms pour les contrôleurs
use Application\Controllers\Comment\UpdateComment\UpdateComment;
use Application\Controllers\Comment\AddComment\AddComment;
use Application\Controllers\Homepage\Homepage;
use Application\Controllers\Post\Post;

// Structure try-catch pour gérer les erreurs
try {
    // Vérifie si l'action est présente dans l'URL et n'est pas vide
    if (isset($_GET['action']) && $_GET['action'] !== '') {
        
        // Vérifie l'action 'post' et s'assure que l'ID du billet est valide
        if ($_GET['action'] === 'post') {
            if (isset($_GET['id']) && $_GET['id'] > 0) {
                $identifier = $_GET['id'];
                // Appelle le contrôleur pour afficher le billet spécifique
                (new Post())->execute($identifier);
            } else {
                throw new Exception('Aucun identifiant de billet envoyé');
            }
        
        // Vérifie l'action 'addComment' et s'assure que l'ID du billet est valide
        } elseif ($_GET['action'] === 'addComment') {
            if (isset($_GET['id']) && $_GET['id'] > 0) {
                $identifier = $_GET['id'];
                // Appelle le contrôleur pour ajouter un commentaire sur le billet
                (new AddComment())->execute($identifier, $_POST);
            } else {
                throw new Exception('Aucun identifiant de billet envoyé');
            }
        
        // Vérifie l'action 'updateComment' et s'assure que l'ID du commentaire est valide
        } elseif ($_GET['action'] === 'updateComment') {
            if (isset($_GET['id']) && $_GET['id'] > 0) {
                $identifier = $_GET['id'];
                // Si la méthode de la requête est POST (soumission du formulaire), on prend les données du formulaire
                $input = null;
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $input = $_POST;
                }
                // Appelle le contrôleur pour mettre à jour un commentaire spécifique
                (new UpdateComment())->execute($identifier, $input);
            } else {
                throw new Exception('Aucun identifiant de commentaire envoyé');
            }
        
        // Si aucune des actions ci-dessus n'est trouvée, on lance une exception de page non trouvée
        } else {
            throw new Exception("La page que vous recherchez n'existe pas.");
        }
    
    // Si aucune action n'est spécifiée dans l'URL, on affiche la page d'accueil
    } else {
        (new Homepage())->execute();
    }
} catch (Exception $e) {
    // Récupère le message d'erreur et l'affiche via le fichier d'erreur
    $errorMessage = $e->getMessage();
    require('templates/error.php');
}
