<!--
    # La base d'une structure MVC est constitué de 3 fichiers (Modèle - Vue - Contrôleur)
    # Ce fichier homepage.php représente la vue et sert à afficher les informations
    # Dans cet exemple, il sert à définir l'affichage de la page
    # Vue : cette partie se concentre sur l'affichage. Elle ne fait presque aucun calcul et se contente de récupérer des variables pour savoir ce qu'elle doit afficher. On y trouve essentiellement du code HTML mais aussi quelques boucles et conditions PHP très simples, pour afficher par exemple une liste de messages.
 -->
<!DOCTYPE html>
    <html>
        <head>
            <meta charset="utf-8" />
            <title>Le blog de l'AVBN</title>
            <link href="style.css" rel="stylesheet" />
        </head>

        <body>
            <h1>Le super blog de l'AVBN !</h1>
            <p>Derniers billets du blog :</p>

            <?php      
                foreach ($posts as $post) {
            ?>
                <div class="news">
                    <h3>
                        <?= htmlspecialchars($post['title']); ?>
                        <em>le <?= $post['french_creation_date']; ?></em>
                    </h3>
                    <p>
                        <?= nl2br(htmlspecialchars($post['content'])); // On affiche le contenu du billet
                        ?>
                        <br/>
                        <em><a href="#">Commentaires</a></em>
                    </p>
                </div>
            <?php
            } // Fin de la boucle des billets
            ?>
        </body>
    </html>