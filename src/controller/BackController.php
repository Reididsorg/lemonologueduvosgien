<?php

namespace BrunoGrosdidier\Blog\src\controller;

use BrunoGrosdidier\Blog\config\Parameter;

class BackController extends Controller
{
    public function addOnePost()
    {
        return $this->view->render('addOnePost');
    }

    public function createOnePost(Parameter $postForm)
    {
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

    public function editOnePost($postId)
    {
        $post = $this->postDAO->selectOnePost($postId);
        $comments = $this->commentDAO->selectAllCommentsOfOnePost($postId);
        return $this->view->render('editOnePost', [
            'post' => $post,
            'comments' => $comments
        ]);
    }

    public function refreshOnePost($postId, Parameter $postForm)
    {
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

    public function removeOnePost($postId)
    {
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

    public function createOneComment($postId, Parameter $commentForm)
    {
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

    public function editOneComment($commentId)
    {
        $comment = $this->commentDAO->selectOneComment($commentId);
        return $this->view->render('editOneComment', [
            'comment' => $comment
        ]);
    }

    public function refreshOneComment($commentId, Parameter $commentForm)
    {
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

    public function removeOneComment($commentId, $postId)
    {
        $this->commentDAO->deleteOneComment($commentId);
        $this->sentBySession->set('messageRemoveOneComment', 'Le commentaire a été supprimé');
        header('Location: index.php?action=getOnePostAndHisComments&postId='.$postId);
    }

    public function flagOneComment($commentId, $postId)
    {
        $this->commentDAO->flagOneComment($commentId);
        $this->sentBySession->set('messageFlagOneComment', 'Le commentaire a bien été signalé');
        $post = $this->postDAO->selectOnePost($postId);
        $comments = $this->commentDAO->selectAllCommentsOfOnePost($postId);
        return $this->view->render('getOnePostAndHisComments', [
            'post' => $post,
            'comments' => $comments
        ]);
    }

    public function unflagOneComment($commentId)
    {
        $this->commentDAO->unflagOneComment($commentId);
        $this->sentBySession->set('MessageUnflagOneComment', 'Le commentaire a bien été désignalé');
        header('Location: index.php?action=admin');
    }

    public function editProfile()
    {
        return $this->view->render('editProfile');
    }

    public function refreshPassword(Parameter $passwordForm)
    {
        if($passwordForm->get('submit')) {
            $this->userDAO->updatePassword($passwordForm, $this->sentBySession->get('pseudo'));
            $this->sentBySession->set('messageRefreshPassword', 'Le mot de passe a été mis à jour');
            header('Location: index.php?action=profile');
        }
        return $this->view->render('refreshpassword');
    }

    public function logout()
    {
        $this->sentBySession->stop();
        $this->sentBySession->start();
        $this->sentBySession->set('messageLogout', 'A bientôt !');
        header('Location: index.php?action=getAllPosts');
    }

    public function removeAccount()
    {
        $this->userDAO->deleteCurrentUser($this->sentBySession->get('pseudo'));
        $this->sentBySession->stop();
        $this->sentBySession->start();
        $this->sentBySession->set('messageRemoveAccount', 'Votre compte a bien été supprimé');
        header('Location: index.php?action=getAllPosts');
    }

    public function removeSpecificUser($userId)
    {
        var_dump($userId);
        $this->userDAO->deleteSpecificUser($userId);
        $this->sentBySession->set('messageRemoveSpecificUser', 'L\'utilisateur a bien été supprimé');
        header('Location: index.php?action=admin');
    }

    public function admin ()
    {
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
