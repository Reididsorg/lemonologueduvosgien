<?php $this->title = 'Création du billet'; ?>

<h1>Création du billet</h1>
<p><a href="/index.php">Retour à la liste des billets</a></p>

<!-- Wrapper  -->
<div id="wrapper">
    <!-- Formulaire d'ajout de billet de blog -->
    <div id="form-add-post">
        <form method="post" action="index.php?action=createOnePost" method="post">
            <label for="title">Titre</label><br>
            <input type="text" id="title" name="title"><br>
            <label for="content">Contenu</label><br>
            <textarea id="content" name="content"></textarea><br>
            <!--<label for="author">Auteur</label><br>
            <input type="text" id="author" name="author"><br>-->
            <input type="submit" value="Envoyer" id="submit" name="submit">
        </form>

    </div>
</div>
