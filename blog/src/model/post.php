<!--
    # La base d'une structure MVC est constitué de 3 fichiers (Modèle - Vue - Contrôleur)
    # Ce fichier représente le MODELE et sert à traiter les données 
    # Dans cet exemple, il sert à récupèrer les billets
    # Modèle : cette partie gère ce qu'on appelle la logique métier de votre site. Elle comprend notamment la gestion des données qui sont stockées, mais aussi tout le code qui prend des décisions autour de ces données. Son objectif est de fournir une interface d'action la plus simple possible au contrôleur. On y trouve donc entre autres des algorithmes complexes et des requêtes SQL.
 -->
<?php
//src/model/post.php

class Post {

    public string $title;
    public string $frenchCreationDate;
    public string $content;
    public string $identifier;
}

class PostRepository
{
    public ?PDO $database = null;

    public function getPost(string $identifier): Post {
        
        $this->dbConnect();

        $statement = $this->database->prepare(
            "SELECT id, title, content, DATE_FORMAT(creation_date, '%d/%m/%Y à %Hh%imin%ss') AS french_creation_date FROM posts WHERE id = ?"
        );
        $statement->execute([$identifier]);

        $row = $statement->fetch();
        $post = new Post();
        $post->title = $row['title'];
        $post->frenchCreationDate = $row['french_creation_date'];
        $post->content = $row['content'];
        $post->identifier = $row['id'];

        return $post;
    }

function getPosts(): array
    {
        // Connexion à la base de données
        $this->dbConnect();
        // On récupère les 5 derniers billets
        $statement = $this->database->query(
            "SELECT id, title, content, DATE_FORMAT(creation_date, '%d/%m/%Y à %Hh%imin%ss') AS french_creation_date FROM posts ORDER BY creation_date DESC LIMIT 0, 5"
        );
        $posts = [];
        while ($row = $statement->fetch()) {
            $post = new Post();
            $post->title = $row['title'];
            $post->frenchCreationDate = $row['french_creation_date'];
            $post->content = $row['content'];
            $post->identifier = $row['id'];
            
            $posts[] = $post;
        }
        return $posts;
    }

    public function dbConnect() {
       if($this->database === null) {
        $this->database = new PDO('mysql:host=localhost;dbname=architecture-mvc-php;charset=utf8', 'tamsin', 'password');
        
    }

}
  
    
    }