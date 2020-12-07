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
				if ($action == 'getAllPosts') {
					$this->frontController->getAllPosts();
				}
				elseif ($action == 'getOnePostAndHisComments') {
                    $this->frontController->getOnePostAndHisComments($this->request->getGet()->get('id'));
				}
                elseif ($action == 'editOnePost') {
                    $this->backController->editOnePost($this->request->getGet()->get('id'));
                }
                elseif ($action == 'refreshOnePost') {
                    $this->backController->refreshOnePost($this->request->getGet()->get('id'), $this->request->getPost());
                }
                elseif ($action == 'removeOnePost') {
                    $this->backController->removeOnePost($this->request->getGet()->get('id'));
                }
				elseif ($action == 'addOnePost') {
                    $this->backController->addOnePost();
                }
                elseif ($action == 'createOnePost') {
                    $this->backController->createOnePost($this->request->getPost());
                }
				elseif ($action == 'createOneComment') {
                    $this->backController->createOneComment($this->request->getGet()->get('id'), $this->request->getPost());
				}
				elseif ($action == 'editOneComment') {
                    $this->backController->editOneComment($this->request->getGet()->get('commentId'), $this->request->getGet()->get('postId'));
				}
				elseif ($action == 'refreshOneComment') {
                    $this->backController->refreshOneComment($this->request->getGet()->get('commentId'), $this->request->getPost(), $this->request->getGet()->get('postId'));
				}
                elseif ($action == 'removeOneComment') {
                    $this->backController->removeOneComment($this->request->getGet()->get('commentId'), $this->request->getGet()->get('postId'));
                }
				else{
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
