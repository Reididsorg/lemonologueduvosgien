<?php

namespace BrunoGrosdidier\Blog\config;

class Request
{
    private $sentByGet;
    private $sentByPost;
    private $sentBySession;

    public function __construct()
    {
        if(isset($_GET) && !empty($_GET)) {
            $this->sentByGet = new Parameter($_GET);
        }
        $this->sentByPost = new Parameter($_POST);
        $this->sentBySession = new Session($_SESSION);
    }

    /**
     * @return Parameter
     */
    public function getSentByGet()
    {
        {
            return $this->sentByGet;
        }
    }

    /**
     * @return Parameter
     */
    public function getSentByPost()
    {
        {
            return $this->sentByPost;
        }
    }

    /**
     * @return Session
     */
    public function getSentBySession()
    {
        {
            return $this->sentBySession;
        }
    }
}
