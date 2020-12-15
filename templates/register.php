<?php $this->title = 'Inscription'; ?>

<div id="wrapper">

    <h1>Inscription</h1>

    <div id="form-register">
        <form method="post" action="index.php?action=register">
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