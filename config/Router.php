<?php

namespace BrunoGrosdidier\Blog\config;

use BrunoGrosdidier\Blog\src\controller\FrontController;
use BrunoGrosdidier\Blog\src\controller\BackController;
use BrunoGrosdidier\Blog\src\controller\ErrorController;
use Exception;

Class Router
{
	private $frontController;
    private $backController;
	private $errorController;
	private $request;

    public function __construct()
    {
        $this->frontController = new FrontController();
        $this->backController = new BackController();
        $this->errorController = new ErrorController();
        $this->request = new Request();
    }

	public function run()
	{
	    try {
	        $action = $this->request->getGet()->get('action');
			if (isset($action)) {

			    switch ($action) {

                    case 'getAllPosts':
                        $this->frontController->getAllPosts();
                        break;
                    case 'getOnePostAndHisComments':
                        $this->frontController->getOnePostAndHisComments($this->request->getGet()->get('postId'));
                        break;
                    case 'editOnePost':
                        $this->backController->editOnePost($this->request->getGet()->get('postId'));
                        break;
                    case 'refreshOnePost':
                        $this->backController->refreshOnePost($this->request->getGet()->get('postId'), $this->request->getPost());
                        break;
                    case 'removeOnePost':
                        $this->backController->removeOnePost($this->request->getGet()->get('postId'));
                        break;
                    case 'addOnePost':
                        $this->backController->addOnePost();
                        break;
                    case 'createOnePost':
                        $this->backController->createOnePost($this->request->getPost());
                        break;
                    case 'createOneComment':
                        $this->backController->createOneComment($this->request->getGet()->get('postId'), $this->request->getPost());
                        break;
                    case 'editOneComment':
                        $this->backController->editOneComment($this->request->getGet()->get('commentId'), $this->request->getGet()->get('postId'));
                        break;
                    case 'refreshOneComment':
                        $this->backController->refreshOneComment($this->request->getGet()->get('commentId'), $this->request->getPost(), $this->request->getGet()->get('postId'));
                        break;
                    case 'removeOneComment':
                        $this->backController->removeOneComment($this->request->getGet()->get('commentId'), $this->request->getGet()->get('postId'));
                        break;
                    default:
                        $this->errorController->errorNotFound();
                }

			}
			else {
				$this->frontController->getAllPosts();				
			}
		}
		catch(Exception $e) {
			echo 'Erreur : ' . $e->getMessage();
            $this->errorController->errorServer();
		}
	}
}
