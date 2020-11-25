<?php

// Chargement des classes
//require_once('config/autoloader.php');
//require 'config/autoloader.php';
//require_once('DAO/PostDAO.php');
//require_once('DAO/CommentDAO.php');

//use BrunoGrosdidier\Blog\Config\Autoloader;
//Autoloader::register();

require_once ('vendor/autoload.php');
//require 'vendor/autoload.php';

use BrunoGrosdidier\Blog\DAO\PostDAO;
use BrunoGrosdidier\Blog\DAO\CommentDAO;

function getAllPosts()
{
	$postManager = new PostDAO();
	$posts = $postManager->selectAllPosts();

	require('templates/frontend/getAllPostsView.php');
}

function getOnePost()
{
	$postManager = new BrunoGrosdidier\Blog\DAO\PostDAO();
	$commentManager = new BrunoGrosdidier\Blog\DAO\CommentDAO();
	$post = $postManager->selectOnePost($_GET['id']);
	$comments = $commentManager->selectAllCommentsOfOnePost($_GET['id']);

	require('templates/frontend/getOnePostView.php');
}

function addOneComment($postId, $author, $comment)
{
	$commentManager = new BrunoGrosdidier\Blog\DAO\CommentDAO();

	$affectedLines = $commentManager->insertOneComment($postId, $author, $comment);

	if ($affectedLines === false) {
		throw new Exception('Impossible d\'ajouter le commentaire !');
	}
	else {
		header('Location: index.php?action=getOnePost&id=' . $postId);
	}
}

function editOneComment()
{
	$commentManager = new BrunoGrosdidier\Blog\DAO\CommentDAO();
	$postManager = new BrunoGrosdidier\Blog\DAO\PostDAO();

	$comment = $commentManager->selectOneComment($_GET['commentId']);
	$post = $postManager->selectOnePost($_GET['postId']);

	require('templates/frontend/editOneCommentView.php');		
}

function refreshOneComment($commentId, $commentText, $postId)
{
	$commentManager = new BrunoGrosdidier\Blog\DAO\CommentDAO();

	$affectedLine = $commentManager->updateOneComment($commentId, $commentText);

	if ($affectedLine === false) {
		throw new Exception('Impossible de mettre à jour le commentaire !');
	}
	else {
		header('Location: index.php?action=getOnePost&id=' . $postId);
	}
}
