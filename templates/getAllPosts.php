<?php $title = 'Accueil'; ?>

<h1>ACCUEIL</h1>

<!-- Wrapper  -->
<div id="wrapper">
    <!-- Billets de blog  -->
    <div id="blog-posts">
        <h2>Derniers billets du blog</h2>
        <?php
        foreach($posts as $post)
        {
            ?>
            <div class="news">
                <h3><?= $post->getPostTitle() ?><em> le <?= $post->getPostDateFr() ?></em></h3>
                <p><?= $post->getPostContent() ?>
                    <br />
                    <em><a href="index.php?action=getOnePost&amp;id=<?= $post->getId() ?>">Commentaires</a></em>
                </p>
            </div>
            <?php
        } // Fin de la boucle des billets
        ?>
    </div>
</div>
