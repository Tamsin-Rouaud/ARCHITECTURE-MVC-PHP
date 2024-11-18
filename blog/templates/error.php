<?php 
// src/templates/error.php

# =>    Rôle : Fichier de vue pour afficher un message d'erreur en cas d'exception
# =>    Fonctionnalité : Affiche un message d'erreur générique si une exception est levée dans le contrôleur principal
# =>    Utilité : Gère les erreurs d'exécution et affiche un message à l'utilisateur

// Déclaration d'un titre pour la page
$title = "Le blog de l'AVBN"; 

// Début de la capture du contenu via la fonction ob_start()
// Cela permet de stocker le contenu de la page dans un buffer plutôt que de l'envoyer directement au navigateur
ob_start(); 
?>

<!-- Affichage du titre de la page -->
<h1>Le super blog de l'AVBN !</h1>

<!-- Affichage d'un message d'erreur dynamique -->
<!-- Le message d'erreur est affiché à partir de la variable $errorMessage -->
<p>Une erreur est survenue : <?= $errorMessage ?></p>

<?php 
// Fin de la capture du contenu avec ob_get_clean()
// Cela enregistre le contenu généré dans une variable et vide le buffer
$content = ob_get_clean(); 
?>

<!-- Inclusion du fichier de mise en page (layout.php) -->
<!-- Ce fichier est chargé pour structurer la page avec le contenu dynamique généré ici -->
<?php require_once('layout.php'); 
?>
