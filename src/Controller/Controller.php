<?php

namespace BrunoGrosdidier\Blog\src\Controller;

use BrunoGrosdidier\Blog\config\Request;
use BrunoGrosdidier\Blog\src\Constraint\Validation;
use BrunoGrosdidier\Blog\src\DAO\PostDAO;
use BrunoGrosdidier\Blog\src\DAO\CommentDAO;
use BrunoGrosdidier\Blog\src\DAO\UserDAO;
use BrunoGrosdidier\Blog\src\Model\Pagination;
use BrunoGrosdidier\Blog\src\Service\SendEmail;
use BrunoGrosdidier\Blog\src\Service\Recaptcha;
use Twig\Environment;
use Twig\Extension\DebugExtension;
use Twig\Loader\FilesystemLoader;

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
    protected $sendEmail;
    protected $recaptcha;
    /**
     * @var Environment
     */
    protected $twig;

    public function __construct()
    {
        $this->postDAO = new PostDAO();
        $this->commentDAO = new CommentDAO();
        $this->userDAO = new UserDAO();
        $this->pagination = new Pagination();
        $this->sendEmail = new SendEmail();
        $this->recaptcha = new Recaptcha();
        $this->validation = new Validation();
        $request = new Request();
        $this->sentByGet = $request->getSentByGet();
        $this->sentByPost = $request->getSentByPost();
        $this->sentBySession = $request->getSentBySession();
        $this->getTwig();
    }

    public function getTwig()
    {
        $loader = new FilesystemLoader(__DIR__ . '/../../templates');
        $this->twig = new Environment($loader, [
            //TODO: activate cache in production
            //'cache' => '/path/to/compilation_cache',
            //TODO: disable debug in production
            'debug' => true,
        ]);
        $this->twig->addExtension(new DebugExtension());
        $this->twig->addGlobal('session', $this->sentBySession);
    }

    public function render($template, $options = [])
    {
        echo $this->twig->render($template, $options);
    }
}
