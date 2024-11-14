<!--
    # La base d'une structure MVC est constitué de 3 fichiers (Modèle - Vue - Contrôleur).
    # Ce fichier homepage.php représente le CONTROLEUR et sert à faire (l'intermédiaire) le lien entre la vue et le modèle.
    # On préfère créer un seul fichier par contrôleur qui seront tous rassemblés dans le même dossier. Chaque fichier définit une fonction qui sera appelée par le routeur.
    # Contrôleur : cette partie gère les échanges avec l'utilisateur. C'est en quelque sorte l'intermédiaire entre l'utilisateur, le modèle et la vue. Le contrôleur va recevoir des requêtes de l'utilisateur. Pour chacune, il va demander au modèle d'effectuer certaines actions (lire des articles de blog depuis une base de données, supprimer un commentaire) et de lui renvoyer les résultats (la liste des articles, si la suppression est réussie). Puis il va adapter ce résultat et le donner à la vue. Enfin, il va renvoyer la nouvelle page HTML, générée par la vue, à l'utilisateur.
 -->
<?php
//controllers/post.php_check_syntax
require_once('src/model.php');

function post(string $identifier) {
    $post = getPost($identifier);
    $comments = getComments($identifier);

    require_once('templates/post.php');
}