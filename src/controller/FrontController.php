<?php

namespace BrunoGrosdidier\Blog\src\controller;

use BrunoGrosdidier\Blog\DAO\PostDAO;
use BrunoGrosdidier\Blog\DAO\CommentDAO;
use BrunoGrosdidier\Blog\src\model\View;

class FrontController extends Controller
{
    public function getAllPosts()
    {
        $posts = $this->postDAO->selectAllPosts();
        return $this->view->render('getAllPosts', [
            'posts' => $posts
        ]);
    }

    public function getOnePostAndHisComments($postId)
    {
        $post = $this->postDAO->selectOnePost($postId);
        $comments = $this->commentDAO->selectAllCommentsOfOnePost($postId);
        return $this->view->render('getOnePostAndHisComments', [
            'post' => $post,
            'comments' => $comments
        ]);
    }
}
