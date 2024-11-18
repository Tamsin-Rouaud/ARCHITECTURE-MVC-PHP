<?php
declare(strict_types=1);
// src/lib/Database.php

# =>    Rôle : Gère la connexion à la base de données
# =>    Fonctionnalité : Crée une connexion à la base de donnée MySQL via PDO
# =>    Utilité : Permet de se connecter à la base de données pour effectuer des opérations (lecture, écriture, etc)

// Namespace utilisé pour organiser la classe dans la bibliothèque dédiée à la base de données
namespace Application\Lib\Database;

// Définition de la classe DatabaseConnection
class DatabaseConnection {
    // Propriété pour stocker l'instance de la connexion PDO
    // Le type `?PDO` indique que cette propriété peut être soit un objet PDO, soit `null`
    public ?\PDO $database = null;

    // Méthode pour obtenir la connexion à la base de données
    public function getConnection(): \PDO 
    {
        // Vérifie si la connexion n'a pas encore été établie
        if ($this->database === null) {
            // Création d'une nouvelle instance de PDO pour se connecter à la base de données
            $this->database = new \PDO(
                'mysql:host=localhost;dbname=architecture-mvc-php;charset=utf8', // DSN (Data Source Name)
                'tamsin', // Nom d'utilisateur de la base de données
                'password' // Mot de passe de la base de données
            );
        }

        // Retourne l'instance de la connexion PDO
        return $this->database;
    }
}
