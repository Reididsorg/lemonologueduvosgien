<?php $title = 'Accueil';

//var_dump($posts);
?>

<?php
if(null!==($this->session->get('message'))) {
    ?>
    <p style="background-color: #008000; color: #fff; font-weight: bold;"><?= $this->session->show('message'); ?></p>
    <?php
}
?>

<div id="wrapper">

    <h1>ACCUEIL</h1>

    <div id="posts">

        <?php
        foreach($posts as $post)
        {
            ?>
            <div>
                <h2>
                    <a href="index.php?action=getOnePostAndHisComments&amp;id=<?= $post->getId() ?>"><?= $post->getPostTitle() ?></a>
                </h2>
                <p>
                    <?= $post->getPostContent() ?>
                </p>
                <em>(<?= $post->getPostDateFr() ?>) par <strong><?= $post->getPostAuthor() ?></strong></em>
            </div>
            <?php
        }
        ?>
    </div>

    <br>
    <br>
    <br>
    <br>

    <div id="add-new-post">
        <p><a href="index.php?action=addOnePost">Ajouter un billet</a></p>
    </div>

</div>
