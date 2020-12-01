<?php

namespace BrunoGrosdidier\Blog\config;

use BrunoGrosdidier\Blog\src\controller\FrontController;
use BrunoGrosdidier\Blog\src\controller\ErrorController;
use Exception;

Class Router
{

	private $frontController;
	private $errorController;

    public function __construct()
    {
        $this->frontController = new FrontController();
        $this->errorController = new ErrorController();
    }

	public function run()
	{


		try {
			if (isset($_GET['action'])) {
				if ($_GET['action'] == 'getAllPosts') {
					$this->frontController->getAllPosts();
				}
				elseif ($_GET['action'] == 'getOnePost') {
					if (isset($_GET['id']) && $_GET['id'] > 0) {
						$this->frontController->getOnePost();						
					}
					else {
						//throw new Exception('Aucun identifiant de billet envoyé');
                        $this->errorController->errorNotFound();
					}
				}
				elseif ($_GET['action'] == 'addOneComment') {
					if (isset($_GET['id']) && $_GET['id'] > 0) {
						if (!empty($_POST['author']) && !empty($_POST['comment'])) {
							$this->frontController->addOneComment($_GET['id'], $_POST['author'], $_POST['comment']);							
						}
						else {
							throw new Exception('Tous les champs ne sont pas remplis !');
						}
					}
					else {
						//throw new Exception('Aucun identifiant de billet envoyé');
                        $this->errorController->errorNotFound();
					}
				}
				elseif ($_GET['action'] == 'editOneComment') {
					if (isset($_GET['commentId']) && $_GET['commentId'] > 0) {
						$this->frontController->editOneComment();						
					}
					else {
						throw new Exception('Aucun identifiant de commentaire envoyé');
					}
				}
				elseif ($_GET['action'] == 'refreshOneComment') {
					if (isset($_GET['postId']) && $_GET['postId'] > 0) {
						if (isset($_GET['commentId']) && $_GET['commentId'] > 0) {
							if (!empty($_POST['commentText'])) {
								$this->frontController->refreshOneComment($_GET['commentId'], $_POST['commentText'], $_GET['postId']);								
							}
							else {
								throw new Exception('Le champ n\'est pas rempli !');
							}	
						}
						else {
							//throw new Exception('Aucun identifiant de commentaire envoyé');
                            $this->errorController->errorNotFound();
						}
					}
					else {
						throw new Exception('Putain ! Aucun identifiant de billet envoyé');
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
