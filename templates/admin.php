<?php $this->title = 'Administration'; ?>

<?= null!==($this->session->get('messageCreateOnePost')) ? '<p style="background-color: #008000; color: #fff; font-weight: bold;">'.$this->session->show('messageCreateOnePost').'</p>' : ''; ?>
<?= null!==($this->session->get('messageRefreshOnePost')) ? '<p style="background-color: #008000; color: #fff; font-weight: bold;">'.$this->session->show('messageRefreshOnePost').'</p>' : ''; ?>
<?= null!==($this->session->get('messageRemoveOnePost')) ? '<p style="background-color: #008000; color: #fff; font-weight: bold;">'.$this->session->show('messageRemoveOnePost').'</p>' : ''; ?>
<?= null!==($this->session->get('messageRemoveOneComment')) ? '<p style="background-color: #008000; color: #fff; font-weight: bold;">'.$this->session->show('messageRemoveOneComment').'</p>' : ''; ?>
<?= null!==($this->session->get('messageUnflagOneComment')) ? '<p style="background-color: #008000; color: #fff; font-weight: bold;">'.$this->session->show('messageUnflagOneComment').'</p>' : ''; ?>
<?= null!==($this->session->get('messageRemoveSpecificUser')) ? '<p style="background-color: #008000; color: #fff; font-weight: bold;">'.$this->session->show('messageRemoveSpecificUser').'</p>' : ''; ?>
<?= null!==($this->session->get('messageActivateSpecificUser')) ? '<p style="background-color: #008000; color: #fff; font-weight: bold;">'.$this->session->show('messageActivateSpecificUser').'</p>' : ''; ?>

<div id="wrapper">

    <h1>Administration</h1>

    <div id="admin">
        <h2>Articles</h2>
        <p><a href="index.php?action=createOnePost">Ajouter un article</a></p>
        <table>
            <tr>
                <td>Id</td>
                <td>Titre</td>
                <td>Contenu</td>
                <td>Auteur</td>
                <td>Date</td>
                <td>Actions</td>
            </tr>
            <?php
            foreach ($posts as $post)
            {
                ?>
                <tr>
                    <td><?= htmlspecialchars($post->getId());?></td>
                    <td><a href="index.php?action=getOnePostAndHisComments&postId=<?= htmlspecialchars($post->getId());?>"><?= htmlspecialchars($post->getPostTitle());?></a></td>
                    <td><?= substr(htmlspecialchars($post->getPostContent()), 0, 150);?></td>
                    <td><?= htmlspecialchars($post->getPostAuthor());?></td>
                    <td>Créé le : <?= htmlspecialchars($post->getPostDateFr());?></td>
                    <td>
                        <a href="index.php?action=editOnePost&postId=<?= $post->getId(); ?>">Modifier</a>
                        <a href="index.php?action=removeOnePost&postId=<?= $post->getId(); ?>">Supprimer</a>
                    </td>
                </tr>
                <?php
            }
            ?>
        </table>
        <br>
        <h2>Commentaires signalés</h2>
        <table>
            <tr>
                <td>Id</td>
                <td>Pseudo</td>
                <td>Message</td>
                <td>Date</td>
                <td>Actions</td>
            </tr>
            <?php
            foreach ($flagComments as $flagComment)
            {
                ?>
                <tr>
                    <td><?= htmlspecialchars($flagComment->getId());?></td>
                    <td><?= htmlspecialchars($flagComment->getCommentAuthor());?></td>
                    <td><?= substr(htmlspecialchars($flagComment->getCommentContent()), 0, 150);?></td>
                    <td>Créé le : <?= htmlspecialchars($flagComment->getCommentDateFr());?></td>
                    <td>
                        <a href="index.php?action=unflagOneComment&commentId=<?= $flagComment->getId(); ?>">Désignaler</a>
                        <a href="index.php?action=removeOneComment&commentId=<?= $flagComment->getId(); ?>">Supprimer</a>
                    </td>
                </tr>
                <?php
            }
            ?>
        </table>
        <br>
        <h2>Utilisateurs</h2>
        <table>
            <tr>
                <td>Id</td>
                <td>Pseudo</td>
                <td>Date</td>
                <td>Rôle</td>
                <td>Actions</td>
            </tr>
            <?php
            foreach ($users as $user)
            {
                ?>
                <tr>
                    <td><?= htmlspecialchars($user->getId());?></td>
                    <td><?= htmlspecialchars($user->getUserPseudo());?></td>
                    <td>Créé le : <?= htmlspecialchars($user->getUserCreatedAtFr());?></td>
                    <td><?= htmlspecialchars($user->getRoleName());?></td>
                    <td>
                        <?php
                        if($user->getRoleName() === 'new') {
                            ?>
                            <a href="index.php?action=activateSpecificUser&userId=<?= $user->getId(); ?>">Activer</a>
                        <?php
                        }
                        ?>
                        <a href="index.php?action=removeSpecificUser&userId=<?= $user->getId(); ?>">Supprimer</a>
                    </td>
                </tr>
                <?php
            }
            ?>
        </table>
        <br>
    </div>

    <br>
    <br>
    <br>
    <br>

</div>