<?php

namespace BrunoGrosdidier\Blog\src\controller;

use BrunoGrosdidier\Blog\config\Parameter;

class BackController extends Controller
{
    private function checkLoggedIn()
    {
        if(!$this->sentBySession->get('pseudo')) {
            $this->sentBySession->set('messageCheckLoggedIn', 'Vous devez vous connecter');
            header('Location: index.php?action=login');
        } else {
            return true;
        }
    }

    private function checkAdmin()
    {
        $this->checkLoggedIn();
        if(!($this->sentBySession->get('roleName') === 'admin')) {
            $this->sentBySession->set('messageCheckAdmin', 'Vous n\'avez pas le droit d\'accéder à cette page');
            header('Location: index.php?action=editProfile');
        } else {
            return true;
        }
    }

    public function admin ()
    {
        if ($this->checkAdmin()) {
            $posts = $this->postDAO->selectAllPosts();
            $flagComments = $this->commentDAO->getFlagComments();
            $users = $this->userDAO->getAllUsers();
            return $this->view->render('admin', [
                'posts' => $posts,
                'flagComments'=>$flagComments,
                'users'=>$users
            ]);
        }
    }

    public function addOnePost()
    {
        if($this->checkAdmin()) {
            return $this->view->render('addOnePost');
        }
    }

    public function createOnePost(Parameter $postForm)
    {
        if($this->checkAdmin()) {
            if($postForm->get('submit')) {
                $errors = $this->validation->validate($postForm, 'Post');
                if(!$errors) {
                    $this->postDAO->insertOnePost($postForm, $this->sentBySession->get('id'));
                    $this->sentBySession->set('messageCreateOnePost', 'Le billet a été créé');
                    if($this->sentBySession->get('roleName') === 'admin') {
                        header('Location: index.php?action=admin');
                    }
                    if($this->sentBySession->get('roleName') === 'editor') {
                        header('Location: index.php?action=getAllPosts');
                    }
                }
                return $this->view->render('addOnePost', [
                    'postForm' => $postForm,
                    'errors' => $errors
                ]);
            }
            return $this->view->render('addOnePost', [
                'postForm' => $postForm
            ]);
        }
    }

    public function editOnePost($postId)
    {
        if($this->checkAdmin()) {
            $post = $this->postDAO->selectOnePost($postId);
            $comments = $this->commentDAO->selectAllCommentsOfOnePost($postId);
            return $this->view->render('editOnePost', [
                'post' => $post,
                'comments' => $comments
            ]);
        }
    }

    public function refreshOnePost($postId, Parameter $postForm)
    {
        if($this->checkAdmin()) {
            if($postForm->get('submit')) {
                $errors = $this->validation->validate($postForm, 'Post');
                if(!$errors) {
                    $this->postDAO->updateOnePost($postId, $postForm, $this->sentBySession->get('id'));
                    $this->sentBySession->set('messageRefreshOnePost', 'Le billet a été modifié');
                    header('Location: index.php?action=admin');
                }
                $post = $this->postDAO->selectOnePost($postId);
                $post->setPostTitle($postForm->get('title'));
                $post->setPostContent($postForm->get('content'));
                return $this->view->render('editOnePost', [
                    'post' => $post,
                    'errors' => $errors
                ]);
            }
            return $this->view->render('editOnePost', [
                'post' => $postForm
            ]);
        }
    }

    public function removeOnePost($postId)
    {
        if($this->checkAdmin()) {
            $this->commentDAO->deleteAllCommentsOfOnePost($postId);
            $this->postDAO->deleteOnePost($postId);
            $this->sentBySession->set('messageRemoveOnePost', 'Le billet a été supprimé');
            if($this->sentBySession->get('roleName') === 'admin') {
                header('Location: index.php?action=admin');
            }
            if($this->sentBySession->get('roleName') === 'editor') {
                header('Location: index.php?action=getAllPosts');
            }
        }
    }

    public function createOneComment($postId, Parameter $commentForm)
    {
        if($this->checkLoggedIn()) {
            if($commentForm->get('submit')) {
                $errors = $this->validation->validate($commentForm, 'Comment');
                if(!$errors) {
                    $this->commentDAO->insertOneComment($postId, $commentForm);
                    $post = $this->postDAO->selectOnePost($postId);
                    $comments = $this->commentDAO->selectAllCommentsOfOnePost($postId);
                    $this->sentBySession->set('messageCreateOneComment', 'Le commentaire a été créé');
                    return $this->view->render('getOnePostAndHisComments', [
                        'post' => $post,
                        'comments' => $comments
                    ]);
                }
                $post = $this->postDAO->selectOnePost($postId);
                $comments = $this->commentDAO->selectAllCommentsOfOnePost($postId);
                return $this->view->render('getOnePostAndHisComments', [
                    'post' => $post,
                    'comments' => $comments,
                    'commentForm' => $commentForm,
                    'errors' => $errors
                ]);
            }
            $post = $this->postDAO->selectOnePost($postId);
            $comments = $this->commentDAO->selectAllCommentsOfOnePost($postId);
            return $this->view->render('getOnePostAndHisComments', [
                'post' => $post,
                'comments' => $comments
            ]);
        }
    }

    public function editOneComment($commentId)
    {
        if($this->checkAdmin()) {
            $comment = $this->commentDAO->selectOneComment($commentId);
            return $this->view->render('editOneComment', [
                'comment' => $comment
            ]);
        }
    }

    public function refreshOneComment($commentId, Parameter $commentForm)
    {
        if($this->checkAdmin()) {
            $comment = $this->commentDAO->selectOneComment($commentId);
            if($commentForm->get('submit')) {
                $errors = $this->validation->validate($commentForm, 'Comment');
                if (!$errors) {
                    $this->commentDAO->updateOneComment($commentId, $commentForm);
                    $this->sentBySession->set('messageRefreshOneComment', 'Le commentaire a été modifié');
                    header('Location: index.php?action=getOnePostAndHisComments&postId=' . $comment->getCommentPostId());
                }
                return $this->view->render('editOneComment', [
                    'comment' => $comment,
                    'commentForm' => $commentForm,
                    'errors' => $errors
                ]);
            }
            return $this->view->render('editOneComment', [
                'comment' => $comment,
                'commentForm' => $commentForm
            ]);
        }
    }

    public function removeOneComment($commentId, $postId)
    {
        if($this->checkAdmin()) {
            $this->commentDAO->deleteOneComment($commentId);
            $this->sentBySession->set('messageRemoveOneComment', 'Le commentaire a été supprimé');
            header('Location: index.php?action=getOnePostAndHisComments&postId='.$postId);
        }
    }

    public function flagOneComment($commentId, $postId)
    {
        if($this->checkLoggedIn()) {
            $this->commentDAO->flagOneComment($commentId);
            $this->sentBySession->set('messageFlagOneComment', 'Le commentaire a bien été signalé');
            $post = $this->postDAO->selectOnePost($postId);
            $comments = $this->commentDAO->selectAllCommentsOfOnePost($postId);
            return $this->view->render('getOnePostAndHisComments', [
                'post' => $post,
                'comments' => $comments
            ]);
        }
    }

    public function unflagOneComment($commentId)
    {
        if($this->checkAdmin()) {
            $this->commentDAO->unflagOneComment($commentId);
            $this->sentBySession->set('messageUnflagOneComment', 'Le commentaire a bien été désignalé');
            header('Location: index.php?action=admin');
        }
    }

    public function editProfile()
    {
        if ($this->checkLoggedIn()) {
            return $this->view->render('editProfile');
        }
    }

    public function refreshPassword(Parameter $passwordForm)
    {
        if ($this->checkLoggedIn()) {
            if($passwordForm->get('submit')) {
                $this->userDAO->updatePassword($passwordForm, $this->sentBySession->get('pseudo'));
                $this->sentBySession->set('messageRefreshPassword', 'Le mot de passe a été mis à jour');
                header('Location: index.php?action=profile');
            }
            return $this->view->render('refreshpassword');
        }
    }

    public function logout()
    {
        if ($this->checkLoggedIn()) {
            $this->sentBySession->stop();
            $this->sentBySession->start();
            $this->sentBySession->set('messageLogout', 'A bientôt !');
            header('Location: index.php?action=getAllPosts');
        }
    }

    public function removeAccount()
    {
        if ($this->checkLoggedIn()) {
            $this->userDAO->deleteCurrentUser($this->sentBySession->get('pseudo'));
            $this->sentBySession->stop();
            $this->sentBySession->start();
            $this->sentBySession->set('messageRemoveAccount', 'Votre compte a bien été supprimé');
            header('Location: index.php?action=getAllPosts');
        }
    }

    public function activateSpecificUser($userId)
    {
        if($this->checkAdmin()) {
            $this->userDAO->activateSpecificUser($userId);
            $this->sentBySession->set('messageActivateSpecificUser', 'L\'utilisateur a bien été activé avec le rôle EDITOR');
            header('Location: index.php?action=admin');
        }
    }

    public function removeSpecificUser($userId)
    {
        if($this->checkAdmin()) {
            $this->userDAO->deleteSpecificUser($userId);
            $this->sentBySession->set('messageRemoveSpecificUser', 'L\'utilisateur a bien été supprimé');
            header('Location: index.php?action=admin');
        }
    }
}
