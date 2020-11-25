<?php

namespace BrunoGrosdidier\Blog\src\controller;

class ErrorController
{
    public function errorNotFound()
    {
        require_once ('templates/error/error_404.php');
    }
    public function errorServer()
    {
        require_once ('templates/error/error_500.php');
    }	
}