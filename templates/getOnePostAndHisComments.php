<?php $this->title = 'Billet de blog'; ?>

<?= null!==($this->session->get('messageCreateOneComment')) ? '<p style="background-color: #008000; color: #fff; font-weight: bold;">'.$this->session->show('messageCreateOneComment').'</p>' : ''; ?>
<?= null!==($this->session->get('messageRefreshOneComment')) ? '<p style="background-color: #008000; color: #fff; font-weight: bold;">'.$this->session->show('messageRefreshOneComment').'</p>' : ''; ?>
<?= null!==($this->session->get('messageRemoveOneComment')) ? '<p style="background-color: #008000; color: #fff; font-weight: bold;">'.$this->session->show('messageRemoveOneComment').'</p>' : ''; ?>

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
                <a href="index.php?action=editOnePost&postId=<?= $post->getId() ?>">Modifier ce billet</a>
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
                    <a href="index.php?action=editOneComment&commentId=<?= $comment->getId() ?>">Modifier ce commentaire</a>
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
