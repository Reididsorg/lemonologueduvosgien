<?php $this->title = 'Modification du billet'; ?>

<div id="wrapper">

    <h1>Modification du billet</h1>
    <p><em>(Dernière modification : <?= htmlspecialchars($post->getPostDateFr()); ?>,  par <strong><?= htmlspecialchars($post->getPostAuthor()); ?></strong>)</em></p>

    <div id="form-post">
        <?php include ('formPost.php'); ?>
    </div>

    <br>
    <br>
    <br>
    <br>

    <?php
    if($this->session->get('roleName') === 'editor') {
    ?>
        <div id="delete-post">
            <p>
                <a href="index.php?action=removeOnePost&postId=<?= $post->getId() ?>">Supprimer ce billet</a>
            </p>
        </div>
    <?php
    }
    ?>

</div>