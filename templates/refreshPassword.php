<?php $this->title = 'Modifier mon mot de passe'; ?>

<div id="wrapper">

    <h1>Modifier mon mot de passe</h1>

    <div id="form-Password">
        <form method="post" action="index.php?action=refreshPassword">
            <label for="password">Mot de passe</label>
            <br>
            <input type="password" id="password" name="password">
            <br>
            <input type="submit" value="Mettre à jour" id="submit" name="submit">
        </form>
    </div>

    <br>
    <br>
    <br>
    <br>

</div>