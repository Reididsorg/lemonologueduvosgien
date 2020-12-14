<?php $this->title = 'Inscription'; ?>

<div id="wrapper">

    <h1>Modification du billet</h1>
    <p><em>(Dernière modification : <?= isset($userForm) ? htmlspecialchars($userForm->get('dateFr')): ''; ?>)</em></p>

    <div id="form-post">
        <form method="post" action="index.php?action=createOneUser">
            <label for="pseudo">Pseudo</label>
            <br>
            <input type="text" id="pseudo" name="pseudo" value="<?= isset($userForm) ? htmlspecialchars($userForm->get('pseudo')): ''; ?>">
            <br>
            <?= isset($errors['pseudo']) ? $errors['pseudo'] : ''; ?>
            <br>
            <label for="password">Mot de passe</label>
            <br>
            <input type="password" id="password" name="password">
            <br>
            <?= isset($errors['password']) ? $errors['password'] : ''; ?>
            <br>
            <input type="submit" value="Inscription" id="submit" name="submit">
        </form>
    </div>

    <br>
    <br>
    <br>
    <br>

</div>