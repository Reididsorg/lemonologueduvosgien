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
            header('Location: index.php?action=getOnePost&id=' . $postId);
        }

    }
}
