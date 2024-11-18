<?php
// src/controllers/comment/AddComment.php

# =>    Rôle : Gère l'ajout d'un commentaire sur un billet de blog 
# =>    Fonctionnalité : Récupère les données du formulaire de commentaire (auteur et texte) et les insère dans la base de données
# =>    Utilité : Permet aux utilisateurs de commenter les billets de blog.

// Déclare un namespace pour organiser les classes et éviter les conflits de noms
namespace Application\Controllers\Comment\AddComment;

// Inclut les fichiers nécessaires
require_once('src/model/comment.php'); // Pour gérer les commentaires
require_once('src/lib/Database.php');  // Pour établir une connexion à la base de données

// Utilise les namespaces pour les classes importées
use Application\Lib\Database\DatabaseConnection;
use Application\Model\Comment\CommentRepository;

// Définition de la classe AddComment
class AddComment {
    
    // Méthode principale de la classe qui gère l'ajout d'un commentaire
    public function execute(string $post, array $input) {
        // Initialisation des variables pour l'auteur et le contenu du commentaire
        $author = null;
        $comment = null;

        // Vérifie si les données du formulaire sont présentes et non vides
        if (!empty($input['author']) && !empty($input['comment'])) {
            $author = $input['author'];  // Récupère le nom de l'auteur
            $comment = $input['comment']; // Récupère le contenu du commentaire
        } else {
            // Si les données sont invalides, lance une exception avec un message d'erreur
            throw new \Exception('Les données du formulaire sont invalides.');
        }

        // Crée une instance du CommentRepository pour gérer les commentaires
        $commentRepository = new CommentRepository();
        // Associe une connexion à la base de données au CommentRepository
        $commentRepository->connection = new DatabaseConnection();

        // Tente d'ajouter le commentaire à la base de données
        $success = $commentRepository->createComment($post, $author, $comment);
        
        // Vérifie si l'ajout a réussi
        if (!$success) {
            // Si l'ajout échoue, lance une exception avec un message d'erreur
            throw new \Exception("Impossible d'ajouter le commentaire !");
        } else {
            // Si l'ajout réussit, redirige l'utilisateur vers la page du billet
            header("Location: index.php?action=post&id=" . $post);
        }
    }
}
