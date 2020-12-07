<?php

namespace BrunoGrosdidier\Blog\src\controller;

use BrunoGrosdidier\Blog\src\model\View;

class ErrorController extends Controller
{
    public function errorNotFound()
    {
        return $this->view->render('error_404');
    }
    public function errorServer()
    {
        return $this->view->render('error_500');
    }	
}
