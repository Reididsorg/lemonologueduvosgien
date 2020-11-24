<?php
session_start();

//Récupération et filtrage des données du formulaire
$memberPseudo = htmlspecialchars($_POST['pseudo']);
$memberPass = htmlspecialchars($_POST['password']);
$memberEmail = htmlspecialchars($_POST['email']);

// Connexion à la base de données
try
{
	$bdd = new PDO('mysql:host=localhost:3308;dbname=lemonologueduvosgien;charset=utf8', 'lemonologueduvosgien', 'Vosgica88');
}
catch(Exception $e)
{
	die('Erreur : '.$e->getMessage());
}

// Hachage du mot de passe
$passHache = password_hash($memberPass, PASSWORD_DEFAULT);

// Insertion dans la bdd
$req = $bdd->prepare('INSERT INTO members(member_pseudo, member_pass, member_email, member_signin_date) VALUES(:member_pseudo, :member_pass, :member_email, CURDATE())');
$req->execute(array(
	'member_pseudo' => $memberPseudo,
	'member_pass' => $passHache,
	'member_email' => $memberEmail));

//  Récupération de l'utilisateur et de son pass
$req = $bdd->prepare('SELECT id, member_pseudo FROM members WHERE member_pseudo = :member_pseudo');
$req->execute(array(
   'member_pseudo' => $memberPseudo));
$resultat = $req->fetch();

// Définition des variables de session id et pseudo
if (!$resultat)
{
  echo 'Problème dans la récupération des infos membre';
}
else
{
	session_start();
	$_SESSION['id'] = $resultat['id'];
	$_SESSION['pseudo'] = $resultat['member_pseudo'];
}
	
// Redirection vers la homepage
header('Location: http://lemonologueduvosgien.local/index.php');