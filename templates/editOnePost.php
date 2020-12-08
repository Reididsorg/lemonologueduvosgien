<?php $this->title = 'Modification du billet'; ?>

<div id="wrapper">

    <h1>Modification du billet</h1>
    <p><em>(Dernière modification : <?= htmlspecialchars($post->getPostDateFr()) ?>)</em></p>

    <div id="edit-post">

        <form method="post" action="index.php?action=refreshOnePost&amp;id=<?= $post->getId() ?>&amp;postTitle=<?= $post->getPostTitle() ?>&amp;postContent=<?= $post->getPostContent() ?>" method="post">

            <label for="title">Titre</label>
            <br>
            <input type="text" id="title" name="title" value="<?= $post->getPostTitle() ?>">
            <br>
            <label for="content">Contenu</label>
            <br>
            <textarea id="content" name="content"><?= $post->getPostContent() ?></textarea>
            <br>
            <!--
            <label for="author">Auteur</label><br>
            <input type="text" id="author" name="author">
            <br>
            -->
            <br>
            <input type="submit" value="Modifier" id="submit" name="submit">
        </form>

    </div>

    <br>
    <br>
    <br>
    <br>

    <div id="delete-post">
        <p>
            <a href="index.php?action=removeOnePost&amp;id=<?= $post->getId() ?>">Supprimer ce billet</a>
        </p>
    </div>

</div>