<!--
    # La base d'une structure MVC est constitué de 3 fichiers (Modèle - Vue - Contrôleur)
    # Ce fichier index.php représente le contrôleur et sert à faire (l'intermédiaire) le lien entre les 2 autres fichiers de la structure
    # Dans cet exemple, il sert à faire le lien entre le modèle et l'affichage
    # Contrôleur : cette partie gère les échanges avec l'utilisateur. C'est en quelque sorte l'intermédiaire entre l'utilisateur, le modèle et la vue. Le contrôleur va recevoir des requêtes de l'utilisateur. Pour chacune, il va demander au modèle d'effectuer certaines actions (lire des articles de blog depuis une base de données, supprimer un commentaire) et de lui renvoyer les résultats (la liste des articles, si la suppression est réussie). Puis il va adapter ce résultat et le donner à la vue. Enfin, il va renvoyer la nouvelle page HTML, générée par la vue, à l'utilisateur.
 -->
<?php
    require_once('src/model.php');

    $posts = getPosts();

    require_once('templates/homepage.php');


