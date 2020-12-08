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
                        <a href="/pages/blog/blog.php">BLOG</a>
                    </li>
                    <li class="nav-item">
                        <a href="/pages/cv/cv.php">CV</a>
                    </li>
                    <li class="nav-item">
                        <a href="/pages/contact/contact.php">CONTACT</a>
                    </li>
                </ul>
            </nav>

            <div>
                <?php
                /*
                // Vérification de l'existence d'une éventuelle session_cache_expire
                if (!empty($_SESSION)) {
                    ?>
                    <div>
                        Bienvenue <span class="member-name"><?= $_SESSION['pseudo'] ?></span> ! | <a href="/pages/logout/logout.php">Se déconnecter</a>
                    </div>
                    <?php
                }
                else {
                    ?>
                    <div>
                        <a href="/pages/login/form_login.php">Se connecter</a> | <a href="/pages/signin/form_signin.php">S'inscrire</a>
                    </div>
                    <?php
                }
                */
                ?>
            </div>

        </header>

        <?= $content ?>

    </body>

</html>
