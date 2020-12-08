<?php $this->title = 'Modification du billet'; ?>

<div id="wrapper">

    <h1>Modification du billet</h1>
    <p><em>(Dernière modification : <?= htmlspecialchars($post->getPostDateFr()) ?>)</em></p>

    <div id="form-post">
        <?php include ('formPost.php'); ?>
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