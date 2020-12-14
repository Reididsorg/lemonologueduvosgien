<?php $this->title = 'Modification du commentaire'; ?>

<?= null!==($this->session->get('messageFlagOneComment')) ? '<p style="background-color: #008000; color: #fff; font-weight: bold;">'.$this->session->show('messageFlagOneComment').'</p>' : ''; ?>

<div id="wrapper">

    <h1>Modification du commentaire</h1>
    <p><em>Dernière modification : <?= htmlspecialchars($comment->getCommentDateFr()) ?></em></p>
    <?php
    if ($comment->isCommentFlag()) {
        ?>
        <p>Ce commentaire a été signalé <img src="public/images/flag.png" alt="commentaire signalé" width="20" height="20"></p>
    <?php
    }
    else {
        ?>
        <p><a href="index.php?action=flagOneComment&commentId=<?= $comment->getId() ?>">Signaler ce commentaire</a></p>
    <?php
    }
    ?>

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
            <a href="index.php?action=removeOneComment&commentId=<?= $comment->getId() ?>&postId=<?= $comment->getCommentPostId() ?>">Supprimer ce commentaire</a>
        </p>
    </div>

</div>