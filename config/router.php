<?php
namespace BrunoGrosdidier\Blog\config;
use Exception;

Class Router
{
	public function run()
	{


		try {
			if (isset($_GET['action'])) {
				if ($_GET['action'] == 'getAllPosts') {
					getAllPosts();
				}
				elseif ($_GET['action'] == 'getOnePost') {
					if (isset($_GET['id']) && $_GET['id'] > 0) {
						getOnePost();
					}
					else {
						throw new Exception('Aucun identifiant de billet envoyé');
					}
				}
				elseif ($_GET['action'] == 'addOneComment') {
					if (isset($_GET['id']) && $_GET['id'] > 0) {
						if (!empty($_POST['author']) && !empty($_POST['comment'])) {
							addOneComment($_GET['id'], $_POST['author'], $_POST['comment']);
						}
						else {
							throw new Exception('Tous les champs ne sont pas remplis !');
						}
					}
					else {
						throw new Exception('Aucun identifiant de billet envoyé');
					}
				}
				elseif ($_GET['action'] == 'editOneComment') {
					if (isset($_GET['commentId']) && $_GET['commentId'] > 0) {
						editOneComment();
					}
					else {
						throw new Exception('Aucun identifiant de commentaire envoyé');
					}
				}
				elseif ($_GET['action'] == 'refreshOneComment') {
					if (isset($_GET['postId']) && $_GET['postId'] > 0) {
						if (isset($_GET['commentId']) && $_GET['commentId'] > 0) {
							if (!empty($_POST['commentText'])) {
								refreshOneComment($_GET['commentId'], $_POST['commentText'], $_GET['postId']);
							}
							else {
								throw new Exception('Le champ n\'est pas rempli !');
							}	
						}
						else {
							throw new Exception('Aucun identifiant de commentaire envoyé');	
						}
					}
					else {
						throw new Exception('Putain ! Aucun identifiant de billet envoyé');
					}			
				}			
			}
			else {
				getAllPosts();
			}
		}
		catch(Exception $e) {
			echo 'Erreur : ' . $e->getMessage();
		}


	}
}
