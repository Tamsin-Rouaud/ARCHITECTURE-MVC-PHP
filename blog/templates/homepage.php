<!--
    # La base d'une structure MVC est constitué de 3 fichiers (Modèle - Vue - Contrôleur)
    # Ce fichier homepage.php représente la VUE et sert à afficher les informations
    # Dans cet exemple, il sert à définir l'affichage de la page
    # Vue : cette partie se concentre sur l'affichage. Elle ne fait presque aucun calcul et se contente de récupérer des variables pour savoir ce qu'elle doit afficher. On y trouve essentiellement du code HTML mais aussi quelques boucles et conditions PHP très simples, pour afficher par exemple une liste de messages.
 -->

<?php $title = "Le blog de l'AVBN"; ?>

<?php ob_start(); ?>
<h1>Le super blog de l'AVBN !</h1>
<p>Derniers billets du blog :</p>

<?php      
    foreach ($posts as $post) {
?>
    <div class="news">
        <h3>
            <?= htmlspecialchars($post->title); ?>
            <em>le <?= $post->french_creation_date; ?></em>
        </h3>
        <p>
            <?= nl2br(htmlspecialchars($post->content)); // On affiche le contenu du billet
            ?>
            <br/>
            <em><a href="index.php?action=post&id=<?= urlencode($post->identifier) ?>">Commentaires</a></em>
        </p>
    </div>
<?php
}

$content = ob_get_clean();

require_once('layout.php');
?>
   