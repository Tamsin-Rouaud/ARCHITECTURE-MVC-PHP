<!--
    # La base d'une structure MVC est constitué de 3 fichiers (Modèle - Vue - Contrôleur)
    # Ce fichier index.php représente le ROUTEUR, il a pour rôle de recevoir toutes les requêtes de l'application et de 
    router chacune vers le bon contrôleur. 
    # On préfère créer un seul fichier par contrôleur qui seront tous rassemblés dans le même dossier. Chaque fichier définit une fonction qui sera appelée par le routeur.
    -->
<?php

    require_once('src/controllers/homepage.php');
    require_once('src/controllers/post.php');
    require_once('src/controllers/add_comment.php');

try {
    if(isset($_GET['action']) && $_GET['action'] !== '') {
        if($_GET['action'] === 'post') {
            if(isset($_GET['id']) && $_GET['id'] > 0) {
                $identifier = $_GET['id'];
                post($identifier);
            } else {
                throw new Exception("aucun identifiant de billet envoyé");
                 
                die;
            }
        } elseif ($_GET['action'] === 'addComment') {
            if(isset($_GET['id']) && $_GET['id'] > 0) {
                $identifier = $_GET['id'];

                addComment($identifier, $_POST);
            } else {
                throw new Exception("aucun identifiant de billet envoyé");

                die;
            }
        } else {
            throw new Exception("La page que vous recherchez n'existe pas.");
        }
    } else {
        homepage();
    }
} catch(Exception $e) {
    $errorMessage = $e->getMessage();

    require('templates/error.php');

}
   


