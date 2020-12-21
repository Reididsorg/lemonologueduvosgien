<?php

namespace BrunoGrosdidier\Blog\src\controller;

use BrunoGrosdidier\Blog\config\Request;
use BrunoGrosdidier\Blog\src\constraint\Validation;
use BrunoGrosdidier\Blog\DAO\PostDAO;
use BrunoGrosdidier\Blog\DAO\CommentDAO;
use BrunoGrosdidier\Blog\DAO\UserDAO;
use BrunoGrosdidier\Blog\src\model\View;
use BrunoGrosdidier\Blog\src\model\Pagination;

abstract class Controller
{
    protected $postDAO;
    protected $commentDAO;
    protected $userDAO;
    protected $view;
    protected $sentByGet;
    protected $sentByPost;
    protected $sentBySession;
    protected $validation;
    protected $pagination;

    public function __construct()
    {
        $this->postDAO = new PostDAO();
        $this->commentDAO = new CommentDAO();
        $this->userDAO = new UserDAO();
        $this->view = new View();
        $this->pagination = new Pagination();
        $this->validation = new Validation();
        $request = new Request();
        $this->sentByGet = $request->getSentByGet();
        $this->sentByPost = $request->getSentByPost();
        $this->sentBySession = $request->getSentBySession();
    }
}
