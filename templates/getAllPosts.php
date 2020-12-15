<?php $title = 'Accueil'; ?>

<?= null!==($this->session->get('messageCreateOnePost')) ? '<p style="background-color: #008000; color: #fff; font-weight: bold;">'.$this->session->show('messageCreateOnePost').'</p>' : ''; ?>
<?= null!==($this->session->get('messageRefreshOnePost')) ? '<p style="background-color: #008000; color: #fff; font-weight: bold;">'.$this->session->show('messageRefreshOnePost').'</p>' : ''; ?>
<?= null!==($this->session->get('messageRemoveOnePost')) ? '<p style="background-color: #008000; color: #fff; font-weight: bold;">'.$this->session->show('messageRemoveOnePost').'</p>' : ''; ?>
<?= null!==($this->session->get('messageRegister')) ? '<p style="background-color: #008000; color: #fff; font-weight: bold;">'.$this->session->show('messageRegister').'</p>' : ''; ?>
<?= null!==($this->session->get('messageLogin')) ? '<p style="background-color: #008000; color: #fff; font-weight: bold;">'.$this->session->show('messageLogin').'</p>' : ''; ?>
<?= null!==($this->session->get('messageLogout')) ? '<p style="background-color: #008000; color: #fff; font-weight: bold;">'.$this->session->show('messageLogout').'</p>' : ''; ?>
<?= null!==($this->session->get('messageRemoveAccount')) ? '<p style="background-color: #008000; color: #fff; font-weight: bold;">'.$this->session->show('messageRemoveAccount').'</p>' : ''; ?>

<?php
if($this->session->get('pseudo')) {
?>
    <a href="index.php?action=logout">Déconnexion</a>
    <a href="index.php?action=profile">Profil</a>
    <a href="index.php?action=createOnePost">Ajouter un billet</a>
<?php
}
else {
?>
    <a href="index.php?action=register">Inscription</a>
    <a href="index.php?action=login">Connexion</a>
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
                    <a href="index.php?action=getOnePostAndHisComments&postId=<?= $post->getId() ?>"><?= $post->getPostTitle() ?></a>
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
