<?php $this->title = 'Billet de blog'; ?>

<?php
if(null!==($this->session->get('message'))) {
    ?>
    <p style="background-color: #008000; color: #fff; font-weight: bold;"><?= $this->session->show('message'); ?></p>
    <?php
}
?>

<div id="wrapper">

    <div id="post">

        <div>
            <h1>
                <?= htmlspecialchars($post->getPostTitle()); ?>
            </h1>
            <p>
                <?= nl2br(htmlspecialchars($post->getPostContent())); ?>
            </p>
            <em>(<?= $post->getPostDateFr(); ?>) par <strong><?= $post->getPostAuthor() ?></strong></em>
        </div>

        <div>
            <p>
                <a href="index.php?action=editOnePost&amp;id=<?= $post->getId() ?>">Modifier ce billet</a>
            </p>
        </div>

    </div>

    <div id="comments">

        <h2>Commentaires</h2>

        <ul>
        <?php
        foreach($comments as $comment)
        {
            ?>
            <li>
                <div>
                    <strong><?= htmlspecialchars($comment->getCommentAuthor()) ?></strong>
                    <em>(<?= $comment->getCommentDateFr() ?>)</em>
                </div>
                <div><?= nl2br(htmlspecialchars($comment->getCommentContent())) ?></div>
                <div>
                    <a href="index.php?action=editOneComment&amp;commentId=<?= $comment->getId() ?>&amp;postId=<?= $post->getId() ?>">Modifier ce commentaire</a>
                </div>
                <br>
            </li>
            <?php
        }
        ?>
        </ul>

        <h3>Ajouter un commentaire</h3>

        <div id="form-comment">
            <?php include ('formComment.php'); ?>
        </div>

    </div>

</div>
