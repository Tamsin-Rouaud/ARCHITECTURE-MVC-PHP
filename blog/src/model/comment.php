<?php
//src/model/comment.php

class Comment {

    public string $author;
    public string $frenchCreationDate;
    public string $comment;
}

function getComments(string $identifier):array {

        $database = commentDbConnect();
        
        $statement = $database->prepare(
            "SELECT id, author, comment, DATE_FORMAT(comment_date, '%d/%m/%Y à %Hh%imin%ss') AS french_creation_date FROM comments WHERE post_id = ? ORDER BY comment_date DESC"
        );
        $statement->execute([$identifier]);

        $comments = [];
        while(($row = $statement->fetch())) {
            $comment = new Comment();
            $comment->author = $row['author'];
            $comment->frenchCreationDate = $row['french_creation_date'];
            $comment->comment = $row['comment'];
            $comments[] = $comment;
        }
        
        return $comments;
    }

    function createComment(string $post, string $author, string $comment) : bool {
        $database = commentDbConnect();
        $statement = $database ->prepare(
            "INSERT INTO comments(post_id, author, comment, comment_date) VALUES(?, ?, ?, NOW())"
            );
        $affectedLines = $statement->execute([$post, $author, $comment]);
        return ($affectedLines > 0);
    }

function commentDbConnect() {
        try {
            $database = new PDO('mysql:host=localhost;dbname=architecture-mvc-php;charset=utf8', 'tamsin', 'password');
return $database;
        } catch(Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
        
    }