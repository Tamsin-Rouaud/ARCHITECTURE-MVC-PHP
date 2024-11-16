<?php 

// Déclaration du titre de la page
$title = "Le blog de l'AVBN";

// Démarrage de la capture du contenu avec ob_start()
// Cela permet de stocker le contenu dans un tampon au lieu de l'envoyer directement au navigateur
ob_start(); 
?>
<h1>Le super blog de l'AVBN !</h1>

<!-- Affichage du texte statique "Derniers billets du blog :" -->
<p>Derniers billets du blog :</p>

<?php      
// Boucle à travers tous les billets récupérés dans la variable $posts
// Chaque billet est un objet avec des propriétés comme title, frenchCreationDate, et content
foreach ($posts as $post) {
?>
    <div class="news">
        <h3>
            <!-- Affichage du titre du billet avec protection contre les caractères spéciaux -->
            <?= htmlspecialchars($post->title); ?>
            <!-- Affichage de la date de création formatée -->
            <em>le <?= $post->frenchCreationDate; ?></em>
        </h3>
        <p>
            <!-- Affichage du contenu du billet avec une conversion des nouvelles lignes en <br /> -->
            <?= nl2br(htmlspecialchars($post->content)); // On affiche le contenu du billet ?>
            <br/>
            <!-- Lien vers la page des commentaires du billet avec l'URL encodée pour l'identifier -->
            <em><a href="index.php?action=post&id=<?= urlencode($post->identifier) ?>">Commentaires</a></em>
        </p>
    </div>
<?php
}

// Récupération du contenu capturé et nettoyage du tampon de sortie
$content = ob_get_clean();

// Inclusion du fichier de mise en page (layout.php) pour afficher la page complète
require_once('layout.php');
?>
