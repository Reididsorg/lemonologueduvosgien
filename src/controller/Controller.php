<?php

namespace BrunoGrosdidier\Blog\src\controller;

use BrunoGrosdidier\Blog\DAO\PostDAO;
use BrunoGrosdidier\Blog\DAO\CommentDAO;
use BrunoGrosdidier\Blog\src\model\View;

abstract class Controller
{
    protected $postDAO;
    protected $commentDAO;
    protected $view;

    public function __construct()
    {
        $this->postDAO = new PostDAO();
        $this->commentDAO = new CommentDAO();
        $this->view = new View();
    }
}