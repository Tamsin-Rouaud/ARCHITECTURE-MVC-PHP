<?php
// src/controllers/comment/UpdateComment.php

# =>    Rôle : Gère la mise à jour d'un commentaire existant sur un billet de blog
# =>    Fonctionnalité : Récupère les données du formulaire de mise à jour (auteur et texte), les valide, met à jour le commentaire dans la base de données et affiche le formulaire pré-rempli si nécessaire.
# =>    Utilité : Permet aux utilisateurs de modifier leurs commentaires sur un billet de blog.

// Namespace pour organiser le code et éviter les conflits entre classes
namespace Application\Controllers\Comment\UpdateComment;

// Inclusion des fichiers nécessaires pour la classe : contrôleur parent, base de données et modèle des commentaires
require_once('src/model/comment.php');
require_once('src/lib/Database.php');

use Application\Lib\Database\DatabaseConnection; // Utilisation de la classe de connexion à la base de données
use Application\Model\Comment\CommentRepository; // Utilisation du modèle pour interagir avec les commentaires

// Cette classe gère la logique pour mettre à jour un commentaire existant.
class UpdateComment {

     // Méthode principale pour exécuter la mise à jour d'un commentaire.
    public function execute(string $identifier, ?array $input) {
        // Vérifie si des données ont été soumises via le formulaire
        if ($input !== null) {
            $author = null; // Nom de l'auteur du commentaire
            $comment = null; // Contenu du commentaire

            // Vérifie si les champs du formulaire ne sont pas vides
            if (!empty($input['author']) && !empty($input['comment'])) {
                $author = $input['author']; // Récupère le nom de l'auteur
                $comment = $input['comment']; // Récupère le contenu du commentaire
            } else {
                // Si les champs sont vides, une exception est levée
                throw new \Exception('Les données du formulaire sont invalides.');
            }

            // Instanciation du CommentRepository pour interagir avec la base de données
            $commentRepository = new CommentRepository();
            $commentRepository->connection = new DatabaseConnection(); // Définit la connexion à la base de données

            // Appelle la méthode pour mettre à jour le commentaire
            $success = $commentRepository->updateComment($identifier, $author, $comment);

            if (!$success) {
                // Si la mise à jour échoue, une exception est levée
                throw new \Exception('Impossible de modifier le commentaire !');
            } else {
                // Si tout va bien, redirige vers la page de mise à jour avec l'identifiant
                header('Location: index.php?action=updateComment&id=' . $identifier);
                exit(); // Arrête l'exécution après la redirection
            }
        }

        // Si aucune donnée n'a été soumise, on affiche le formulaire pré-rempli avec les données existantes
        $commentRepository = new CommentRepository();
        $commentRepository->connection = new DatabaseConnection(); // Définit la connexion à la base de données

        // Récupère le commentaire correspondant à l'identifiant donné
        $comment = $commentRepository->getComment($identifier);
        if ($comment === null) {
            // Si aucun commentaire n'est trouvé, une exception est levée
            throw new \Exception("Le commentaire $identifier n'existe pas.");
        }

        // Charge le template HTML pour afficher le formulaire de mise à jour
        require('templates\update_comment.php');
    }
}
