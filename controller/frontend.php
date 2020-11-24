<?php

// Chargement des classes
require_once('model/PostManager.php');
require_once('model/CommentManager.php');

function getAllPosts()
{
	$postManager = new BrunoGrosdidier\Blog\Model\PostManager();
	$posts = $postManager->selectAllPosts();

	require('view/frontend/getAllPostsView.php');
}

function getOnePost()
{
	$postManager = new BrunoGrosdidier\Blog\Model\PostManager();
	$commentManager = new BrunoGrosdidier\Blog\Model\CommentManager();
	$post = $postManager->selectOnePost($_GET['id']);
	$comments = $commentManager->selectAllCommentsOfOnePost($_GET['id']);

	require('view/frontend/getOnePostView.php');
}

function addOneComment($postId, $author, $comment)
{
	$commentManager = new BrunoGrosdidier\Blog\Model\CommentManager();

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
	$commentManager = new BrunoGrosdidier\Blog\Model\CommentManager();
	$postManager = new BrunoGrosdidier\Blog\Model\PostManager();

	$comment = $commentManager->selectOneComment($_GET['commentId']);
	$post = $postManager->selectOnePost($_GET['postId']);

	require('view/frontend/editOneCommentView.php');		
}

function refreshOneComment($commentId, $commentText, $postId)
{
	$commentManager = new BrunoGrosdidier\Blog\Model\CommentManager();

	$affectedLine = $commentManager->updateOneComment($commentId, $commentText);

	if ($affectedLine === false) {
		throw new Exception('Impossible de mettre à jour le commentaire !');
	}
	else {
		header('Location: index.php?action=getOnePost&id=' . $postId);
	}
}
