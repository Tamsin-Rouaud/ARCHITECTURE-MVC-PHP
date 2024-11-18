<?php 

# =>    Rôle : Fichier de vue pour modifier un commentaire existant sur un billet de blog
# =>    Fonctionnalité : Affiche un formulaire pré-rempli avec les données actuelles du commentaire pour permettre sa modification
# =>    Utilité : Permet aux utilisateurs de modifier leurs commentaires via une interface simple et intuitive

// Titre de la page (sera utilisé dans le template principal "layout.php")
$title = "Le blog de l'AVBN"; 
?>

<?php 
// Démarrage de la mise en mémoire tampon pour capturer le contenu de la page
ob_start(); 
?>
<h1>Le super blog de l'AVBN !</h1>
<p>
    <!-- Lien pour retourner au billet associé au commentaire en utilisant son identifiant -->
    <a href="index.php?action=post&id=<?= $comment->post ?>">Retour au billet</a>
</p>

<h2>Modification du commentaire</h2>

<!-- Formulaire pour modifier un commentaire existant -->
<form action="index.php?action=updateComment&id=<?= $comment->identifier ?>" method="post">
   <div>
      <!-- Champ pour saisir le nom de l'auteur, pré-rempli avec les données actuelles -->
      <label for="author">Auteur</label><br />
      <input type="text" id="author" name="author" value="<?= htmlspecialchars($comment->author) ?>"/>
   </div>
   <div>
      <!-- Champ pour modifier le texte du commentaire, pré-rempli avec les données actuelles -->
      <label for="comment">Commentaire</label><br />
      <textarea id="comment" name="comment"><?= htmlspecialchars($comment->comment) ?></textarea>
   </div>
   <div>
      <!-- Bouton pour soumettre les modifications -->
      <input type="submit" />
   </div>
</form>

<?php 
// Récupère le contenu mis en tampon et le stocke dans la variable $content
$content = ob_get_clean(); 
?>

<?php 
// Inclut le fichier de mise en page principal pour afficher la page avec son contenu
require('layout.php'); 
?>
