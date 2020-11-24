<?php 
session_start();
var_dump($_SESSION);
?>
<!DOCTYPE html>
<html lang="fr">

	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
		<meta name="description" content="Le Monologue Du Vosgien">
		<meta name="author" content="Le Vosgien">
		<link rel="icon" href="images/icone-32x32.png">
		<title>LE MONOLOGUE DU VOSGIEN</title>
	</head>

	<body>
	
		<!-- Header  -->	
		<header>	
			<nav id="nav">
				<ul>
					<!-- Logo -->
					<li class="nav-logo">
						<a href="index.html">
							<img src="/images/photo.jpg" alt="" />
						</a>
					</li>
					<!-- Menu -->
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
					<!-- Compte -->
					<?php
					// Vérification de l'existence d'une éventuelle session_cache_expire
					if (!empty($_SESSION)) {
					?>
						<li class="nav-item">Bienvenue <span class="member-name"><?= $_SESSION['pseudo'] ?></span> ! | <a href="/pages/logout/logout.php">Se déconnecter</a></li>
					<?php
					}
					else {
					?>	
						<li class="nav-item"><a href="/pages/login/form_login.php">Se connecter</a> | <a href="/pages/signin/form_signin.php">S\'inscrire</a></li>
					<?php		
					}
					?>						
				</ul>
			</nav>
		</header>

		<h1>BLOG</h1>	
			
		<!-- Wrapper  -->	
		<div id="wrapper">			
		
			<!-- Billets de blog  -->
			<div id="blog-posts">
				<h2>Derniers billets du blog</h2>
				<?php
				// Connexion à la base de données
				try
				{
					$bdd = new PDO('mysql:host=localhost:3308;dbname=lemonologueduvosgien;charset=utf8', 'lemonologueduvosgien', 'Vosgica88');
				}
				catch(Exception $e)
				{
					die('Erreur : '.$e->getMessage());
				}
				// On récupère les 5 derniers billets
				$req = $bdd->query('SELECT id, post_title, post_content, DATE_FORMAT(post_date, \'%d/%m/%Y à %Hh%imin%ss\') AS date_creation_fr FROM posts ORDER BY post_date DESC LIMIT 0, 5');
				while ($donnees = $req->fetch())
				{
					if (!empty($donnees)) {					
					?>
					<div class="news">
						<h3><?= $donnees['post_title'] ?><em> le <?= $donnees['date_creation_fr'] ?></em></h3>
						<p><?= $donnees['post_content'] ?>
							<br />
							<em><a href="commentaires.php?billet=<?= $donnees['id'] ?>">Commentaires</a></em>
						</p>
					</div>
					<?php
					}
				} // Fin de la boucle des billets
				$req->closeCursor();
				?>				
			</div>

		</div>			
			
	</body>
	
</html>