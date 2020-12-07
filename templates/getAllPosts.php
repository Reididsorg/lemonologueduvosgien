<?php $title = 'Accueil'; ?>
<?= $this->session->show('createOnePost'); ?>

<h1>ACCUEIL</h1>

<!-- Wrapper  -->
<div id="wrapper">
    <!-- Ajout d'un nouveau billet -->
    <div id="add-new-post">
        <a href="index.php?action=addOnePost">Ajouter un billet</a>
    </div>


    <!-- Billets de blog  -->
    <div id="blog-posts">
        <h2>Derniers billets du blog</h2>
        <?php
        foreach($posts as $post)
        {
            ?>
            <div class="news">
                <h3><a href="index.php?action=editOnePost&amp;id=<?= $post->getId() ?>"><?= $post->getPostTitle() ?><em> le <?= $post->getPostDateFr() ?></em></a></h3>
                <p><?= $post->getPostContent() ?>
                    <br />
                    <em><a href="index.php?action=getOnePostAndHisComments&amp;id=<?= $post->getId() ?>">Commentaires</a></em>
                </p>
            </div>
            <?php
        } // Fin de la boucle des billets
        ?>
    </div>
</div>
