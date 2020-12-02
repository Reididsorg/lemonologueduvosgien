<?php

namespace BrunoGrosdidier\Blog\src\controller;

use BrunoGrosdidier\Blog\DAO\PostDAO;
use BrunoGrosdidier\Blog\DAO\CommentDAO;
use BrunoGrosdidier\Blog\src\model\View;

class BackController
{
    private $postDAO;
    private $commentDAO;
    private $view;

    public function __construct()
    {
        $this->postDAO = new PostDAO();
        $this->commentDAO = new CommentDAO();
        $this->view = new View();
    }

    public function addOnePost()
    {
        $post = '';
        return $this->view->render('addOnePost', [
            'post' => $post
        ]);
    }

    public function saveOnePost($postTitle, $postContent)
    {
        var_dump($postTitle);
        var_dump($postContent);
        $affectedLines = $this->postDAO->insertOnePost($postTitle, $postContent);
        var_dump($affectedLines);
        if ($affectedLines === false) {
            throw new Exception('Impossible d\'ajouter le billet !');
        }
        else {
            header('Location: index.php?action=getAllPosts');
        }
    }

    public function editOnePost($postId)
    {
        $post = $this->postDAO->selectOnePost($postId);
        $comments = $this->commentDAO->selectAllCommentsOfOnePost($postId);
        return $this->view->render('editOnePost', [
            'post' => $post,
            'comments' => $comments
        ]);
    }

    public function refreshOnePost($id, $postTitle, $postContent)
    {
        $affectedLine = $this->postDAO->updateOnePost($id, $postTitle, $postContent);
        if ($affectedLine === false) {
            throw new Exception('Impossible de mettre à jour le billet !');
        }
        else {
            header('Location: index.php?action=getAllPosts');
        }
    }

    public function removeOnePost ($id)
    {
        $affectedLine = $this->postDAO->deleteOnePost($id);
        if ($affectedLine === false) {
            throw new Exception('Impossible de mettre à jour le billet !');
        }
        else {
            header('Location: index.php?action=getAllPosts');
        }
    }

    public function saveOneComment($postId, $commentAuthor, $commentContent)
    {
        $affectedLines = $this->commentDAO->insertOneComment($postId, $commentAuthor, $commentContent);
        if ($affectedLines === false) {
            throw new Exception('Impossible d\'ajouter le commentaire !');
        }
        else {
            header('Location: index.php?action=getOnePostAndHisComments&id=' . $postId);
        }
    }

    public function editOneComment($id, $postId)
    {
        $comment = $this->commentDAO->selectOneComment($id);
        $post = $this->postDAO->selectOnePost($postId);
        return $this->view->render('editOneComment', [
            'post' => $post,
            'comment' => $comment
        ]);
    }

    public function refreshOneComment($id, $commentContent, $postId)
    {
        $affectedLine = $this->commentDAO->updateOneComment($id, $commentContent);
        if ($affectedLine === false) {
            throw new Exception('Impossible de mettre à jour le commentaire !');
        }
        else {
            header('Location: index.php?action=getOnePostAndHisComments&id=' . $postId);
        }
    }

    public function removeOneComment ($commentId, $postId)
    {
        var_dump($commentId);
        var_dump($postId);

        $affectedLine = $this->commentDAO->deleteOneComment($commentId);
        if ($affectedLine === false) {
            throw new Exception('Impossible de mettre à jour le billet !');
        }
        else {
            header('Location: index.php?action=getOnePostAndHisComments&id=' . $postId);
        }

    }

}
