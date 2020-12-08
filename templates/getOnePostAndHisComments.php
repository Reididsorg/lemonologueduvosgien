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
            <em>(<?= $post->getPostDateFr(); ?>)</em>
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
                    <a href="index.php?action=editOneComment&amp;commentId=<?= $comment->getId() ?>&amp;postId=<?= $post->getId() ?>">(modifier)</a>
                    |
                    <a href="index.php?action=removeOneComment&amp;commentId=<?= $comment->getId() ?>&amp;postId=<?= $post->getId() ?>">(supprimer)</a>
                </div>
                <br>
            </li>
            <?php
        }
        ?>
        </ul>

        <h3>Ajouter un commentaire</h3>

        <form action="index.php?action=createOneComment&amp;id=<?= $post->getId() ?>" method="post">
            <div>
                <label for="author">Auteur</label><br />
                <input type="text" id="author" name="author" />
            </div>
            <div>
                <label for="comment">Commentaire</label><br />
                <textarea id="comment" name="comment"></textarea>
            </div>
            <div>
                <input type="submit" value="Ajouter" id="submit" name="submit">
            </div>
        </form>


    </div>

</div>
