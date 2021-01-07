<?php

namespace BrunoGrosdidier\Blog\src\Controller;

use BrunoGrosdidier\Blog\config\Request;
use BrunoGrosdidier\Blog\src\Constraint\Validation;
use BrunoGrosdidier\Blog\src\DAO\PostDAO;
use BrunoGrosdidier\Blog\src\DAO\CommentDAO;
use BrunoGrosdidier\Blog\src\DAO\UserDAO;
use BrunoGrosdidier\Blog\src\Model\Pagination;
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
        $this->validation = new Validation();
        $request = new Request();
        $this->sentByGet = $request->getSentByGet();
        $this->sentByPost = $request->getSentByPost();
        $this->sentBySession = $request->getSentBySession();
        $this->getTwig();
    }

    public function getTwig()
    {
        $loader = new FilesystemLoader('templates');
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

    public function sendEmailToMe($subjectToMe, $messageToMe)
    {
        // Create the Transport (Exp)
        $transport = (new \Swift_SmtpTransport(EMAIL_HOST, EMAIL_PORT))
            ->setUsername(EMAIL_USERNAME)
            ->setPassword(EMAIL_PASSWORD)
            ->setEncryption(EMAIL_ENCRYPTION) //For Gmail
        ;

        // Create the Mailer using your created Transport
        $mailer = (new \Swift_Mailer($transport));

        // Create a message (Dest)
        $message = (new \Swift_Message($subjectToMe))
            ->setFrom([EMAIL_USERNAME => EMAIL_SUBJECT])
            ->setTo([EMAIL_DEST_1, EMAIL_DEST_2 => EMAIL_DEST_NAME])
            ->setBody($messageToMe, 'text/html')
        ;

        // Send the message
        $result = $mailer->send($message);

        return $result;
    }

    public function sendEmailToUser($userEmail, $userName, $subjectToUser, $messageToUser)
    {
        // Create the Transport (Exp)
        $transport = (new \Swift_SmtpTransport(EMAIL_HOST, EMAIL_PORT))
            ->setUsername(EMAIL_USERNAME)
            ->setPassword(EMAIL_PASSWORD)
            ->setEncryption(EMAIL_ENCRYPTION) //For Gmail
        ;

        // Create the Mailer using your created Transport
        $mailer = (new \Swift_Mailer($transport));

        // Create a message (Dest)
        $message = (new \Swift_Message($subjectToUser))
            ->setFrom([EMAIL_USERNAME => EMAIL_SUBJECT])
            ->setTo([$userEmail, $userEmail => $userName])
            ->setBody($messageToUser, 'text/html')
        ;

        // Send the message
        $result = $mailer->send($message);

        return $result;
    }
}
