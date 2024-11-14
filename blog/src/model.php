<!--
    # La base d'une structure MVC est constitué de 3 fichiers (Modèle - Vue - Contrôleur)
    # Ce fichier model.php représente le MODELE et sert à traiter les données (traitement.php)
    # Dans cet exemple, il sert à se connecter à la base de donnée et récupère les billets
    # Modèle : cette partie gère ce qu'on appelle la logique métier de votre site. Elle comprend notamment la gestion des données qui sont stockées, mais aussi tout le code qui prend des décisions autour de ces données. Son objectif est de fournir une interface d'action la plus simple possible au contrôleur. On y trouve donc entre autres des algorithmes complexes et des requêtes SQL.
 -->
<?php
    
    function getPosts(): array
    {
        // Connexion à la base de données
        $database = dbConnect();
        // On récupère les 5 derniers billets
        $statement = $database->query(
            "SELECT id, title, content, DATE_FORMAT(creation_date, '%d/%m/%Y à %Hh%imin%ss') AS french_creation_date FROM posts ORDER BY creation_date DESC LIMIT 0, 5"
        );
        $posts = [];
        while ($row = $statement->fetch()) {
            $post = [
                'title' => $row['title'],
                'french_creation_date' => $row['french_creation_date'],
                'content' => $row['content'],
                'identifier' => $row['id'],
            ];

            $posts[] = $post;
        }
        return $posts;
    }

    function getPost($identifier) {
        
        $database = dbConnect();

        $statement = $database->prepare(
            "SELECT id, title, content, DATE_FORMAT(creation_date, '%d/%m/%Y à %Hh%imin%ss') AS french_creation_date FROM posts WHERE id = ?"
        );
        $statement->execute([$identifier]);

        $row = $statement->fetch();
        $post = [
            'title' => $row['title'],
            'french_creation_date' => $row['french_creation_date'],
            'content' => $row['content'],
        ];
        return $post;
    }

    function getComments($identifier) {

        $database = dbConnect();
        
        $statement = $database->prepare(
            "SELECT id, author, comment, DATE_FORMAT(comment_date, '%d/%m/%Y à %Hh%imin%ss') AS french_creation_date FROM comments WHERE post_id = ? ORDER BY comment_date DESC"
        );
        $statement->execute([$identifier]);

        $comments = [];
        while(($row = $statement->fetch())) {
            $comment = [
                'author' => $row['author'],
                'french_creation_date' => $row['french_creation_date'],
                'comment' => $row['comment'],
            ];
            $comments[] = $comment;
        }
        return $comments;
    }

    function dbConnect() {
        try {
            $database = new PDO('mysql:host=localhost;dbname=architecture-mvc-php;charset=utf8', 'tamsin', 'password');
        } catch(Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
        return $database;
    }