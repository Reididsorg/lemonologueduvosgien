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

		<h1>CONTACT</h1>
			
		<!-- Wrapper  -->	
		<div id="wrapper">			
		
			<!-- Contact  -->
			<div id="contact">
				<form action="send_email.php" method="post">
					<p>
					<div>
						<label for="firstname">Prenom : </label>
						<input type="text" name="firstname" />
					</div>
					<div>
						<label for="lastname">Nom : </label>
						<input type="text" name="lastname" />
					</div>
					<div>
						<label for="email">Courriel : </label>
						<input type="text" name="email" />
					</div>
					<div>
						<label for="message">Message : </label>
						<textarea id="message" name="message"></textarea>
					</div>
					<div>
						<input type="submit" value="Valider" />
					</div>	
					</p>
				</form>			
			</div>

		</div>			
			
	</body>
	
</html>