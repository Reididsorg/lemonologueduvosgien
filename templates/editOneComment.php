<?php $this->title = 'Modification du commentaire'; ?>

<div id="wrapper">

    <h1>Modification du commentaire</h1>
    <p><em>Dernière modification : <?= htmlspecialchars($comment->getCommentDateFr()) ?></em></p>

    <div id="edit-comment">

        <form action="index.php?action=refreshOneComment&amp;postId=<?= $post->getId() ?>&amp;commentId=<?= $comment->getId() ?> ?>" method="post">
            <label for="commentText">Commentaire</label>
            <br />
            <textarea id="commentText" name="commentText"><?= htmlspecialchars($comment->getCommentContent()) ?></textarea>
            <br>
            <input type="submit" value="Modifier" id="submit" name="submit">
        </form>

    </div>

    <br>
    <br>
    <br>
    <br>

    <div id="delete-comment">
        <p>
            <a href="index.php?action=removeOneComment&amp;commentId=<?= $comment->getId() ?>&amp;postId=<?= $post->getId() ?>">Supprimer ce commentaire</a>
        </p>
    </div>

</div>