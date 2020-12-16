<!DOCTYPE html>
<html lang="fr">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <meta name="description" content="Le Monologue Du Vosgien">
        <meta name="author" content="Le Vosgien">
        <link rel="icon" type="image/png"  href="/images/icone.png" />
        <title><?= $title ?></title>
    </head>

    <body>

        <header>

            <div class="logo">
                <a href="index.html">
                    <img src="/public/images/photo.jpg" alt="" />
                </a>
            </div>

            <nav id="nav">
                <ul>
                    <li class="nav-item">
                        <a href="/index.php">ACCUEIL</a>
                    </li>
                    <li class="nav-item">
                        <a href="index.php?action=getBlog">BLOG</a>
                    </li>
                    <li class="nav-item">
                        <a href="index.php?action=getCv">CV</a>
                    </li>
                    <li class="nav-item">
                        <a href="index.php?action=getContact">CONTACT</a>
                    </li>
                </ul>
            </nav>

            <div>
                <?php
                if($this->session->get('pseudo')) {
                ?>
                    <p>Bonjour <strong><?= $this->session->get('pseudo'); ?></strong></p>
                    <a href="index.php?action=logout">Déconnexion</a>
                    <a href="index.php?action=editProfile">Profil</a>
                    <?php if($this->session->get('roleName') === 'admin') { ?>
                        <a href="index.php?action=admin">Administration</a>
                    <?php } ?>
                <?php
                }
                else {
                ?>
                    <a href="index.php?action=login">Connexion</a>
                    <a href="index.php?action=register">Inscription</a>
                <?php
                }
                ?>
            </div>

        </header>

        <?= $content ?>

    </body>

</html>
