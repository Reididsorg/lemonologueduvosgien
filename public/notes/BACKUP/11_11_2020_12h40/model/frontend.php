<?php

// Récupérer les 5 derniers billets de blog
function getPosts()
{
	$db = dbConnect();
	$req = $db->query('SELECT id, post_title, post_content, DATE_FORMAT(post_date, \'%d/%m/%Y à %Hh%imin%ss\') AS creation_date_fr FROM post ORDER BY post_date DESC LIMIT 0, 5');	

	return $req;
}

// Récupérer 1 billet de blog
function getPost($postId)
{
	$db = dbConnect();
	$req = $db->prepare('SELECT id, post_title, post_content, DATE_FORMAT(post_date, \'%d/%m/%Y à %Hh%imin%ss\') AS creation_date_fr FROM post WHERE id = ?');
	$req->execute(array($postId));
	$post = $req->fetch();

	return $post;
}

// Récupérer les commentaires d'un billet de blog
function getComments($postId)
{
	$db = dbConnect();
	$comments = $db->prepare('SELECT id, comment_author, comment_content, DATE_FORMAT(comment_date, \'%d/%m/%Y à %Hh%imin%ss\') AS comment_date_fr FROM comment WHERE post_id = ? ORDER BY comment_date DESC');
	$comments->execute(array($postId));

	return $comments;
}

// Connexion à la BDD
function dbConnect()
{
	try
	{
		$db = new PDO('mysql:host=localhost:3308;dbname=lemonologueduvosgien;charset=utf8', 'lemonologueduvosgien', 'Vosgica88');
		return $db;
	}
	catch(Exception $e)
	{
		die('Erreur : '.$e->getMessage());
	}	
}