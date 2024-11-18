<?php 
// src/templates/post.php

# =>    Rôle : Fichier de vue pour afficher un billet spécifique et ses commentaires 
# =>    Fonctionnalité : Affiche le détail d'un billet et permet l'ajout de nouveaux commentaires
# =>    Utilité : Présente les données sous forme html pour un billet spécifique

// Définition du titre de la page. Ce titre peut être modifié dans les contrôleurs et sera affiché dans le layout.
$title = "Le blog de l'AVBN";

// Commence le tampon de sortie pour capturer le contenu HTML généré.
ob_start(); 
?>

<!-- Affiche un titre principal pour le blog -->
<h1>Le super blog de l'AVBN !</h1>

<!-- Lien permettant de revenir à la liste des billets -->
<p><a href="index.php">Retour à la liste des billets</a></p>

<!-- Section contenant le billet de blog -->
<div class="news">
    <h3>
        <!-- Affiche le titre du billet, échappé pour éviter des failles de sécurité (XSS) -->
        <?= htmlspecialchars($post->title)?>
        <!-- Affiche la date de création du billet -->
        <em>le <?= $post->frenchCreationDate ?></em>
    </h3>
    <p>
        <!-- Affiche le contenu du billet. La fonction nl2br permet de transformer les sauts de ligne (\n) en balises <br> -->
        <?= nl2br(htmlspecialchars($post->content))?>
    </p>
</div>

<!-- Affiche un titre pour la section des commentaires -->
<h2>Commentaires</h2>

<!-- Formulaire pour ajouter un nouveau commentaire -->
<form action="index.php?action=addComment&id=<?= $post->identifier ?>" method="post">
    <div>
        <!-- Champ pour entrer l'auteur du commentaire -->
        <label for="author">Auteur</label><br>
        <input type="text" id="author" name="author">
    </div>
    <div>
        <!-- Champ pour entrer le commentaire -->
        <label for="comment">Commentaire</label><br>
        <textarea name="comment" id="comment"></textarea>
    </div>
    <div>
        <!-- Bouton d'envoi du formulaire -->
        <input type="submit">
    </div>
</form>

<?php 
    // Boucle pour afficher tous les commentaires associés au billet
    foreach ($comments as $comment) {
?>
    <!-- Affichage de chaque commentaire -->
    <p>
        <strong><?= htmlspecialchars($comment->author) ?></strong>
        le <?= $comment->frenchCreationDate ?> (<a href="index.php?action=updateComment&id=<?= $comment->identifier ?>">modifier</a>)
    </p>

    <p>
        <!-- Affichage du texte du commentaire avec des sauts de ligne transformés en <br> -->
        <?= nl2br(htmlspecialchars($comment->comment)) ?>
    </p>
        
<?php    
    }
    
    // Capture le contenu généré par ob_start() et le stocke dans la variable $content
    $content = ob_get_clean();

    // Charge le layout principal du site avec le contenu généré
    require_once('layout.php');
?>
