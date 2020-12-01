<?php

namespace BrunoGrosdidier\Blog\src\controller;

require_once ('vendor/autoload.php');

use BrunoGrosdidier\Blog\DAO\PostDAO;
use BrunoGrosdidier\Blog\DAO\CommentDAO;

class FrontController
{
    private $postDAO;
    private $commentDAO;

    public function __construct()
    {
        $this->postDAO = new PostDAO();
        $this->commentDAO = new CommentDAO();
    }

	public function getAllPosts()
	{
        $posts = $this->postDAO->selectAllPosts();
		require('templates/frontend/getAllPostsView.php');
	}

	public function getOnePost()
	{
        $post = $this->postDAO->selectOnePost($_GET['id']);
	    $comments = $this->commentDAO->selectAllCommentsOfOnePost($_GET['id']);
		require('templates/frontend/getOnePostView.php');
	}

	public function addOneComment($postId, $commentAuthor, $commentContent)
	{
        $affectedLines = $this->commentDAO->insertOneComment($postId, $commentAuthor, $commentContent);

        if ($affectedLines === false) {
            throw new Exception('Impossible d\'ajouter le commentaire !');
        }
        else {
            header('Location: index.php?action=getOnePost&id=' . $postId);
        }
	}

	public function editOneComment()
	{
        $comment = $this->commentDAO->selectOneComment($_GET['commentId']);
        $post = $this->postDAO->selectOnePost($_GET['postId']);

        require('templates/frontend/editOneCommentView.php');
	}

	public function refreshOneComment($id, $commentContent, $postId)
	{
        $affectedLine = $this->commentDAO->updateOneComment($id, $commentContent);

        //var_dump($affectedLine);

        //var_dump($affectedLine->fetch());

        if ($affectedLine === false) {
            throw new Exception('Impossible de mettre à jour le commentaire !');
        }
        else {
            header('Location: index.php?action=getOnePost&id=' . $postId);
        }

	}

}

