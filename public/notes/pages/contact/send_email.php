<?php
session_start();

//Récupération et filtrage des données du formulaire
$firstname = htmlspecialchars($_POST['firstname']);
$lastname = htmlspecialchars($_POST['lastname']);
$email = htmlspecialchars($_POST['email']);
$message = htmlspecialchars($_POST['message']);

// Envoi du courriel
	
// Redirection vers la homepage
//header('Location: http://lemonologueduvosgien.local/index.php');