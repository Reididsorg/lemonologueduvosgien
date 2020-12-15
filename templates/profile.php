<?php $this->title = 'Mon profil'; ?>

<?= null!==($this->session->get('messageRefreshPassword')) ? '<p style="background-color: #008000; color: #fff; font-weight: bold;">'.$this->session->show('messageRefreshPassword').'</p>' : ''; ?>

<div id="wrapper">

    <h1>Mon profil</h1>

    <div id="profile">
        <h2>Pseudo : <?= $this->session->get('pseudo'); ?></h2>
        <p>Identifiant unique : <?= $this->session->get('id'); ?></p>
        <a href="index.php?action=refreshPassword">Modifier mon mot de passe</a>
        <a href="index.php?action=removeAccount">Supprimer mon compte</a>
    </div>

    <br>
    <br>
    <br>
    <br>

</div>