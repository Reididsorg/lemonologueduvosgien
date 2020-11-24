<?php 

//Récupération et filtrage des données du formulaire
$memberPseudo = htmlspecialchars($_POST['pseudo']);
$memberPass = htmlspecialchars($_POST['password']);

// Connexion à la base de données
try
{
	$bdd = new PDO('mysql:host=localhost:3308;dbname=lemonologueduvosgien;charset=utf8', 'lemonologueduvosgien', 'Vosgica88');
}
catch(Exception $e)
{
	die('Erreur : '.$e->getMessage());
}

//  Récupération de l'utilisateur et de son pass
$req = $bdd->prepare('SELECT id, member_pass FROM members WHERE member_pseudo = :member_pseudo');
$req->execute(array(
  'member_pseudo' => $memberPseudo));
$resultat = $req->fetch();

// Comparaison du pass envoyé via le formulaire avec celui de la base
$isPasswordCorrect = password_verify($memberPass, $resultat['member_pass']);

if (!$resultat)
{
  echo 'Mauvais identifiant ou mot de passe !';
}
else
{
	if ($isPasswordCorrect) {
		session_start();
		$_SESSION['id'] = $resultat['id'];
		$_SESSION['pseudo'] = $memberPseudo;
		echo 'Vous êtes connecté !';
	}
	else {
		echo 'Mauvais identifiant ou mot de passe !';
	}
}

// Redirection vers la homepage
header('Location: http://lemonologueduvosgien.local/index.php');