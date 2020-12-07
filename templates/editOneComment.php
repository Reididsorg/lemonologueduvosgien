<?php $this->title = 'Edition du commentaire'; ?>

<h1>Modification du commentaire de <?= htmlspecialchars($comment->getCommentAuthor()) ?>, le <?= htmlspecialchars($comment->getCommentDateFr()) ?></h1>
<p><a href="/index.php">Retour à la liste des billets</a></p>

<!-- Wrapper  -->
<div id="wrapper">
    <!-- Commentaire du billet de blog  -->
    <div id="blog-post-comment">

        <form action="index.php?action=refreshOneComment&amp;postId=<?= $post->getId() ?>&amp;commentId=<?= $comment->getId() ?> ?>" method="post">
            <div>
                <label for="commentText">Commentaire</label><br />
                <textarea id="commentText" name="commentText"><?= htmlspecialchars($comment->getCommentContent()) ?></textarea>
            </div>
            <div>
                <input type="submit" value="Modifier" id="submit" name="submit">
            </div>
        </form>

    </div>
</div>
