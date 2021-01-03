<?php

namespace BrunoGrosdidier\Blog\config;

use BrunoGrosdidier\Blog\src\Controller\FrontController;
use BrunoGrosdidier\Blog\src\Controller\BackController;
use BrunoGrosdidier\Blog\src\Controller\ErrorController;
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
	        $action = $this->request->getSentByGet()->get('action');
			if (isset($action)) {

			    switch ($action) {
                    case 'getBlog':
                        $this->frontController->getBlog();
                        break;
                    case 'getCv':
                        $this->frontController->getCv();
                        break;
                    case 'getContact':
                        $this->frontController->getContact();
                        break;
                    case 'getAllPosts':
                        $this->frontController->getAllPosts();
                        break;
                    case 'getOnePostAndHisComments':
                        $this->frontController->getOnePostAndHisComments($this->request->getSentByGet()->get('postId'));
                        break;
                    case 'editOnePost':
                        $this->backController->editOnePost($this->request->getSentByGet()->get('postId'));
                        break;
                    case 'refreshOnePost':
                        $this->backController->refreshOnePost($this->request->getSentByGet()->get('postId'), $this->request->getSentByPost());
                        break;
                    case 'removeOnePost':
                        $this->backController->removeOnePost($this->request->getSentByGet()->get('postId'));
                        break;
                    case 'createOnePost':
                        $this->backController->createOnePost($this->request->getSentByPost());
                        break;
                    case 'createOneComment':
                        $this->backController->createOneComment($this->request->getSentByGet()->get('postId'), $this->request->getSentByPost());
                        break;
                    case 'editOneComment':
                        $this->backController->editOneComment($this->request->getSentByGet()->get('commentId'));
                        break;
                    case 'refreshOneComment':
                        $this->backController->refreshOneComment($this->request->getSentByGet()->get('commentId'), $this->request->getSentByPost());
                        break;
                    case 'removeOneComment':
                        $this->backController->removeOneComment($this->request->getSentByGet()->get('commentId'), $this->request->getSentByGet()->get('postId'));
                        break;
                    case 'flagOneComment':
                        $this->backController->flagOneComment($this->request->getSentByGet()->get('commentId'), $this->request->getSentByGet()->get('postId'));
                        break;
                    case 'unflagOneComment':
                        $this->backController->unflagOneComment($this->request->getSentByGet()->get('commentId'));
                        break;
                    case 'register':
                        $this->frontController->register($this->request->getSentByPost());
                        break;
                    case 'activateSpecificUser':
                        $this->backController->activateSpecificUser($this->request->getSentByGet()->get('userId'));
                        break;
                    case 'login':
                        $this->frontController->login($this->request->getSentByPost());
                        break;
                    case 'logout':
                        $this->backController->logout();
                        break;
                    case 'editProfile':
                        $this->backController->editProfile();
                        break;
                    case 'refreshPassword':
                        $this->backController->refreshPassword($this->request->getSentByPost());
                        break;
                    case 'removeAccount':
                        $this->backController->removeAccount();
                        break;
                    case 'removeSpecificUser':
                        $this->backController->removeSpecificUser($this->request->getSentByGet()->get('userId'));
                        break;
                    case 'getAdmin':
                        $this->backController->getAdmin();
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
