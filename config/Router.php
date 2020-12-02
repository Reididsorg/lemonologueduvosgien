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

    public function __construct()
    {
        $this->frontController = new FrontController();
        $this->backController = new BackController();
        $this->errorController = new ErrorController();
    }

	public function run()
	{
	    try {
			if (isset($_GET['action'])) {
				if ($_GET['action'] == 'getAllPosts') {
					$this->frontController->getAllPosts();
				}
				elseif ($_GET['action'] == 'getOnePostAndHisComments') {
					if (isset($_GET['id']) && $_GET['id'] > 0) {
						$this->frontController->getOnePostAndHisComments($_GET['id']);
					}
					else {
                        $this->errorController->errorNotFound();
					}
				}
                elseif ($_GET['action'] == 'editOnePost') {
                    if (isset($_GET['id']) && $_GET['id'] > 0) {
                        $this->backController->editOnePost($_GET['id']);
                    }
                    else {
                        $this->errorController->errorNotFound();
                    }
                }
                elseif ($_GET['action'] == 'refreshOnePost') {
				    //var_dump($_GET);
                    //var_dump($_POST);
                    if (isset($_GET['id']) && $_GET['id'] > 0) {
                        if (!empty($_POST['title']) && !empty($_POST['content'])) {
                            $this->backController->refreshOnePost($_GET['id'], $_POST['title'], $_POST['content']);
                        }
                        else {
                            throw new Exception('Tous les champs ne sont pas remplis !');
                        }
                    }
                    else {
                        $this->errorController->errorNotFound();
                    }
                }
                elseif ($_GET['action'] == 'removeOnePost') {
                    if (isset($_GET['id']) && $_GET['id'] > 0) {
                        $this->backController->removeOnePost($_GET['id']);
                    }
                    else {
                        $this->errorController->errorNotFound();
                    }
                }
				elseif ($_GET['action'] == 'addOnePost') {
                    $this->backController->addOnePost();
                }
                elseif ($_GET['action'] == 'saveOnePost') {
                    if (!empty($_POST['title']) && !empty($_POST['content'])) {
                        $this->backController->saveOnePost($_POST['title'], $_POST['content']);
                    }
                }
				elseif ($_GET['action'] == 'saveOneComment') {
					if (isset($_GET['id']) && $_GET['id'] > 0) {
						if (!empty($_POST['author']) && !empty($_POST['comment'])) {
							$this->backController->saveOneComment($_GET['id'], $_POST['author'], $_POST['comment']);
						}
						else {
							throw new Exception('Tous les champs ne sont pas remplis !');
						}
					}
					else {
                        $this->errorController->errorNotFound();
					}
				}
				elseif ($_GET['action'] == 'editOneComment') {
					if ((isset($_GET['commentId']) && $_GET['commentId'] > 0)) {
                        if(isset($_GET['postId']) && $_GET['postId'] > 0)
                        {
                            //$this->backController->editOneComment();
                            $this->backController->editOneComment($_GET['commentId'], $_GET['postId']);
                        }
                        else {
                            throw new Exception('Aucun identifiant de billet envoyé');
                        }
					}
					else {
						throw new Exception('Aucun identifiant de commentaire envoyé');
					}
				}
				elseif ($_GET['action'] == 'refreshOneComment') {
					if (isset($_GET['postId']) && $_GET['postId'] > 0) {
						if (isset($_GET['commentId']) && $_GET['commentId'] > 0) {
							if (!empty($_POST['commentText'])) {
								$this->backController->refreshOneComment($_GET['commentId'], $_POST['commentText'], $_GET['postId']);
							}
							else {
								throw new Exception('Le champ n\'est pas rempli !');
							}	
						}
						else {
                            $this->errorController->errorNotFound();
						}
					}
					else {
						throw new Exception('Aucun identifiant de billet envoyé');
					}			
				}
                elseif ($_GET['action'] == 'removeOneComment') {
                    if (isset($_GET['commentId']) && $_GET['commentId'] > 0) {
                        if (isset($_GET['postId']) && $_GET['postId'] > 0) {
                            $this->backController->removeOneComment($_GET['commentId'], $_GET['postId']);
                        }
                        else {
                            $this->errorController->errorNotFound();
                        }
                    }
                    else {
                        $this->errorController->errorNotFound();
                    }
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
