<?php $this->title = 'Modification du commentaire'; ?>

<div id="wrapper">

    <h1>Modification du commentaire</h1>
    <p><em>Dernière modification : <?= htmlspecialchars($comment->getCommentDateFr()) ?></em></p>

    <div id="edit-comment">

        <div id="form-comment">
            <?php include ('formComment.php'); ?>
        </div>

    </div>

    <br>
    <br>
    <br>
    <br>

    <div id="delete-comment">
        <p>
            <a href="index.php?action=removeOneComment&commentId=<?= $comment->getId() ?>&postId=<?= $post->getId() ?>">Supprimer ce commentaire</a>
        </p>
    </div>

</div>