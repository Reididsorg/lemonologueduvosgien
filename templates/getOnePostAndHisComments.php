<?php $this->title = 'Billet de blog'; ?>

<?= null!==($this->session->get('messageCreateOneComment')) ? '<p style="background-color: #008000; color: #fff; font-weight: bold;">'.$this->session->show('messageCreateOneComment').'</p>' : ''; ?>
<?= null!==($this->session->get('messageRefreshOneComment')) ? '<p style="background-color: #008000; color: #fff; font-weight: bold;">'.$this->session->show('messageRefreshOneComment').'</p>' : ''; ?>
<?= null!==($this->session->get('messageRemoveOneComment')) ? '<p style="background-color: #008000; color: #fff; font-weight: bold;">'.$this->session->show('messageRemoveOneComment').'</p>' : ''; ?>

<div id="wrapper">

    <div id="post">

        <div>
            <h1>
                <a href="index.php?action=getOnePostAndHisComments&postId=<?= $post->getId() ?>"><?= $post->getPostTitle() ?></a>
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
                    if($this->session->get('roleName') === 'admin' || ($this->session->get('pseudo') === $comment->getCommentAuthor())) {
                        ?>
                        <a href="index.php?action=editOneComment&commentId=<?= $comment->getId() ?>">Modifier</a><br>
                        <?php
                    }

                    if ($comment->isCommentFlag()) {
                        ?>
                        <p><em>Ce commentaire a été signalé <img src="public/images/flag.png" alt="commentaire signalé" width="20" height="20"></em></p>
                        <?php
                    }
                    else {
                        if ($this->session->get('roleName') === 'admin' || $this->session->get('roleName') === 'editor') {
                            ?>
                            <p><em><a href="index.php?action=flagOneComment&commentId=<?= $comment->getId() ?>&postId=<?= $post->getId() ?>">Signaler</a></em></p>
                            <?php
                        }
                    }
                    ?>

                </div>
                <br>
            </li>
            <?php
        }
        ?>
        </ul>

        <?php

        if($this->session->get('roleName') === 'admin' || $this->session->get('roleName') === 'editor') {
            ?>
            <h3>Ajouter un commentaire</h3>

            <div id="form-comment">
                <?php include ('formComment.php'); ?>
            </div>
            <?php
        }
        ?>

    </div>

    <?php
    if($pagination->getPageNumber() > 1) {
        ?>
        <div id="pagination">
            <p>
                <?php
                for($i = 1; $i <= $pagination->getPageNumber(); $i++) {
                    if($pagination->getPage() == $i){
                        ?>
                        <?= $i; ?>
                        <?php
                    } else {
                        ?>
                        <a href="index.php?action=getOnePostAndHisComments&postId=<?= $post->getId() ?>&page=<?= $i; ?>"><?= $i; ?></a>
                        <?php
                    }
                }
                ?>
            </p>
        </div>
        <?php
    }
    ?>

</div>
