<?php $this->title = 'Billet de blog'; ?>

<h1>BILLET DE BLOG</h1>
<p><a href="/index.php">Retour à la liste des billets</a></p>

<!-- Wrapper  -->
<div id="wrapper">
    <!-- Billets de blog  -->
    <div id="blog-post">

        <div class="news">
            <h3>
                <?= htmlspecialchars($post->getPostTitle()); ?>
                <em>le <?= $post->getPostDateFr(); ?></em>
            </h3>

            <p>
                <?= nl2br(htmlspecialchars($post->getPostContent())); ?>
            </p>
        </div>

        <h2>Commentaires</h2>

        <form action="index.php?action=saveOneComment&amp;id=<?= $post->getId() ?>" method="post">
            <div>
                <label for="author">Auteur</label><br />
                <input type="text" id="author" name="author" />
            </div>
            <div>
                <label for="comment">Commentaire</label><br />
                <textarea id="comment" name="comment"></textarea>
            </div>
            <div>
                <input type="submit" value="Enregistrer" id="submit" name="submit">
            </div>
        </form>

        <?php
        foreach($comments as $comment)
        {
            ?>
            <p>
                <strong>
                    <?= htmlspecialchars($comment->getCommentAuthor()) ?>
                </strong> le <?= $comment->getCommentDateFr() ?>
                <a href="index.php?action=editOneComment&amp;commentId=<?= $comment->getId() ?>&amp;postId=<?= $post->getId() ?>">(modifier)</a>
                 |
                <a href="index.php?action=removeOneComment&amp;commentId=<?= $comment->getId() ?>&amp;postId=<?= $post->getId() ?>">(supprimer)</a>
            </p>
            <p><?= nl2br(htmlspecialchars($comment->getCommentContent())) ?></p>
            <?php
        }
        ?>
    </div>
</div>
