<!--
    # La base d'une structure MVC est constitué de 3 fichiers (Modèle - Vue - Contrôleur)
    # Ce fichier index.php représente le ROUTEUR, il a pour rôle de recevoir toutes les requêtes de l'application et de 
    router chacune vers le bon contrôleur. 
    # On préfère créer un seul fichier par contrôleur qui seront tous rassemblés dans le même dossier. Chaque fichier définit une fonction qui sera appelée par le routeur.
    -->
<?php

    require_once('src/controllers/homepage.php');
    require_once('src/controllers/post.php');

    if(isset($_GET['action']) && $_GET['action'] !== '') {
        if($_GET['action'] === 'post') {
            if(isset($_GET['id']) && $_GET['id'] > 0) {
                $identifier = $_GET['id'];
                post($identifier);
            } else {
                echo 'Erreur : aucun identifiant de billet envoyé';
                die;
            }
        } else {
            echo "Erreur 404 : La page que vous recherchez n'existe pas.";
        }
    } else {
        homepage();
    }

   


