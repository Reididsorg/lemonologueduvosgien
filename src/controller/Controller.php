<?php

namespace BrunoGrosdidier\Blog\src\controller;

use BrunoGrosdidier\Blog\config\Request;
use BrunoGrosdidier\Blog\DAO\PostDAO;
use BrunoGrosdidier\Blog\DAO\CommentDAO;
use BrunoGrosdidier\Blog\src\model\View;

abstract class Controller
{
    protected $postDAO;
    protected $commentDAO;
    protected $view;
    protected $get;
    protected $post;
    protected $session;

    public function __construct()
    {
        $this->postDAO = new PostDAO();
        $this->commentDAO = new CommentDAO();
        $this->view = new View();
        $request = new Request();
        $this->get = $request->getGet();
        $this->post = $request->getPost();
        $this->session = $request->getSession();
    }
}
