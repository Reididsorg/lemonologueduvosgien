<?php

namespace BrunoGrosdidier\Blog\src\Controller;

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

    public function getAdmin ()
    {
        if ($this->checkAdmin()) {
            $posts = $this->postDAO->selectAllPosts();
            $flagComments = $this->commentDAO->getFlagComments();
            $users = $this->userDAO->getAllUsers();
            return $this->render('back/admin.html.twig', [
                'posts' => $posts,
                'flagComments'=>$flagComments,
                'users'=>$users
            ]);
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
                    header('Location: index.php?action=getAdmin');
                }
                return $this->render('back/createOnePost.html.twig', [
                    'postForm' => $postForm,
                    'errors' => $errors
                ]);
            }
            return $this->render('back/createOnePost.html.twig', [
                'postForm' => $postForm
            ]);
        }
    }

    public function editOnePost($postId)
    {
        if($this->checkAdmin()) {
            $post = $this->postDAO->selectOnePost($postId);
            $comments = $this->commentDAO->selectAllCommentsOfOnePost($postId);
            return $this->render('back/editOnePost.html.twig', [
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
                    header('Location: index.php?action=getAdmin');
                }
                $post = $this->postDAO->selectOnePost($postId);
                $post->setPostTitle($postForm->get('title'));
                $post->setPostContent($postForm->get('content'));
                return $this->render('back/editOnePost.html.twig', [
                    'post' => $post,
                    'errors' => $errors
                ]);
            }
            return $this->render('back/editOnePost.html.twig', [
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
            header('Location: index.php?action=getAdmin');
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
                    $pagination = $this->pagination->paginate(3, $this->sentByGet->get('page'), $this->commentDAO->countAllComments($postId));
                    $comments = $this->commentDAO->selectAllCommentsOfOnePost($postId, $pagination->getLimit(), $pagination->getStart());
                    $this->sentBySession->set('messageCreateOneComment', 'Le commentaire a été créé');
                    return $this->render('front/getOnePostAndHisComments.html.twig', [
                        'post' => $post,
                        'comments' => $comments,
                        'pagination' => $pagination
                    ]);
                }
                $post = $this->postDAO->selectOnePost($postId);
                $pagination = $this->pagination->paginate(3, $this->sentByGet->get('page'), $this->commentDAO->countAllComments($postId));
                $comments = $this->commentDAO->selectAllCommentsOfOnePost($postId, $pagination->getLimit(), $pagination->getStart());
                return $this->render('front/getOnePostAndHisComments.html.twig', [
                    'post' => $post,
                    'comments' => $comments,
                    'pagination' => $pagination,
                    'commentForm' => $commentForm,
                    'errors' => $errors
                ]);
            }
            $post = $this->postDAO->selectOnePost($postId);
            $pagination = $this->pagination->paginate(3, $this->sentByGet->get('page'), $this->commentDAO->countAllComments($postId));
            $comments = $this->commentDAO->selectAllCommentsOfOnePost($postId, $pagination->getLimit(), $pagination->getStart());
            return $this->render('front/getOnePostAndHisComments.html.twig', [
                'post' => $post,
                'comments' => $comments,
                'pagination' => $pagination
            ]);
        }
    }

    public function editOneComment($commentId)
    {
        if ($this->checkLoggedIn()) {
            $comment = $this->commentDAO->selectOneComment($commentId);
            return $this->render('back/editOneComment.html.twig', [
                'comment' => $comment
            ]);
        }
    }

    public function refreshOneComment($commentId, Parameter $commentForm)
    {
        if ($this->checkLoggedIn()) {
            $comment = $this->commentDAO->selectOneComment($commentId);
            if($commentForm->get('submit')) {
                $errors = $this->validation->validate($commentForm, 'Comment');
                if (!$errors) {
                    $this->commentDAO->updateOneComment($commentId, $commentForm);
                    $this->sentBySession->set('messageRefreshOneComment', 'Le commentaire a été modifié');
                    header('Location: index.php?action=getOnePostAndHisComments&postId=' . $comment->getCommentPostId());
                }
                else {
                    return $this->render('back/editOneComment.html.twig', [
                        'comment' => $comment,
                        'commentForm' => $commentForm,
                        'errors' => $errors
                    ]);
                }

            }
            else {
                return $this->render('back/editOneComment.html.twig', [
                   'comment' => $comment,
                   'commentForm' => $commentForm
               ]);
            }
        }
    }

    public function removeOneComment($commentId, $postId)
    {
        if ($this->checkLoggedIn()) {
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
            return $this->render('front/getOnePostAndHisComments.html.twig', [
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
            header('Location: index.php?action=getAdmin');
        }
    }

    public function editProfile()
    {
        if ($this->checkLoggedIn()) {
            return $this->render('back/editProfile.html.twig');
        }
    }

    public function refreshPassword(Parameter $passwordForm)
    {
        if ($this->checkLoggedIn()) {
            if($passwordForm->get('submit')) {
                $this->userDAO->updatePassword($passwordForm, $this->sentBySession->get('pseudo'));
                $this->sentBySession->set('messageRefreshPassword', 'Le mot de passe a été mis à jour');
                header('Location: index.php?action=editProfile');
            }
            return $this->render('back/refreshpassword.html.twig');
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
            header('Location: index.php?action=getAdmin');
        }
    }

    public function removeSpecificUser($userId)
    {
        if($this->checkAdmin()) {
            $this->userDAO->deleteSpecificUser($userId);
            $this->sentBySession->set('messageRemoveSpecificUser', 'L\'utilisateur a bien été supprimé');
            header('Location: index.php?action=getAdmin');
        }
    }
}
