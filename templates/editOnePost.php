<?php $this->title = 'Edition du billet'; ?>

<h1>Edition du billet du <?= htmlspecialchars($post->getPostDateFr()) ?></h1>
<p><a href="/index.php">Retour à la liste des billets</a></p>

<!-- Wrapper  -->
<div id="wrapper">
    <!-- Formulaire d'ajout de billet de blog -->
    <div id="edit-post">
        <form method="post" action="index.php?action=refreshOnePost&amp;id=<?= $post->getId() ?>&amp;postTitle=<?= $post->getPostTitle() ?>&amp;postContent=<?= $post->getPostContent() ?>" method="post">

            <label for="title">Titre</label><br>
            <input type="text" id="title" name="title" value="<?= $post->getPostTitle() ?>">

            <br>

            <label for="content">Contenu</label><br>
            <textarea id="content" name="content"><?= $post->getPostContent() ?></textarea><br>

            <!--<label for="author">Auteur</label><br>
            <input type="text" id="author" name="author"><br>-->
            <input type="submit" value="Envoyer" id="submit" name="submit">
        </form>
    </div>
    <div id="delete-post"><p><a href="index.php?action=removeOnePost&amp;id=<?= $post->getId() ?>">Supprimer ce billet</a></p></div>
</div>
