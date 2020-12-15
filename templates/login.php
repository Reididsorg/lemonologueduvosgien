<?php $this->title = 'Connexion'; ?>

<div id="wrapper">

    <h1>Connexion</h1>

    <?= null!==($this->session->get('error_login')) ? '<p style="background-color: #ff0000; color: #fff; font-weight: bold;">'.$this->session->show('error_login').'</p>' : ''; ?>

    <div id="form-login">
        <form method="post" action="index.php?action=login">
            <label for="pseudo">Pseudo</label>
            <br>
            <input type="text" id="pseudo" name="pseudo" value="<?= isset($userForm) ? htmlspecialchars($userForm->get('pseudo')): ''; ?>">
            <br>
            <label for="password">Mot de passe</label>
            <br>
            <input type="password" id="password" name="password">
            <br>
            <input type="submit" value="Connexion" id="submit" name="submit">
        </form>
    </div>

    <br>
    <br>
    <br>
    <br>

</div>