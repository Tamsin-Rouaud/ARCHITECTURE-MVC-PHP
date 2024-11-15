<?php

// function test() {
// try {
//     throw new Exception("Ma seconde exception");
// } catch (Exception $exception) {
//     throw new Exception("Ma troisième exception");
    
//     die($exception->getMessage());
    
// }


// throw new Exception("mon exception depuis une fonction");
// }

// try {
//     test();
//     echo "je continue";
// } catch (Exception $exception) {
//     die($exception->getMessage());
// }

class Comment {
    
    public string $author;
    public string $frenchCreationDate;
    public string $comment;
}

$comment = new Comment();
$comment->frenchCreationDate = "10/03/24 à 14h56min23s";