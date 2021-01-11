<?php

namespace BrunoGrosdidier\Blog\src\Controller;

class ErrorController extends Controller
{
    public function errorNotFound()
    {
        //return $this->view->render('error_404');
        return $this->render('error/error_404.html.twig');
    }
    public function errorServer()
    {
        //return $this->view->render('error_500');
        return $this->render('error/error_500.html.twig');
    }
}
