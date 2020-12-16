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
                <?php
                if($this->session->get('roleName') === 'admin' || ($this->session->get('pseudo') === $post->getPostAuthor())) {
                    ?>
                        <a href="index.php?action=editOnePost&postId=<?= $post->getId() ?>">Modifier</a>
                    <?php
                }
                ?>
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

                    <?php
                    if ($comment->isCommentFlag()) {
                        ?>
                        <em>Ce commentaire a été signalé <img src="public/images/flag.png" alt="commentaire signalé" width="20" height="20"></em>
                        <?php
                    }
                    else {
                        if ($this->session->get('roleName') === 'admin' || $this->session->get('roleName') === 'editor') {
                            ?>
                            <em><a href="index.php?action=flagOneComment&commentId=<?= $comment->getId() ?>&postId=<?= $post->getId() ?>">Signaler ce commentaire</a></em>
                            <?php
                        }
                    }
                    ?>

                    <?php
                    if($this->session->get('roleName') === 'admin' || ($this->session->get('pseudo') === $comment->getCommentAuthor())) {
                        ?>
                        <a href="index.php?action=editOneComment&commentId=<?= $comment->getId() ?>">Modifier</a>
                        <?php
                    }
                    ?>
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
