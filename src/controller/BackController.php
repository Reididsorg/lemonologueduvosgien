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
                $affectedLines = $this->postDAO->insertOnePost($postForm);
                if ($affectedLines === false) {
                    throw new Exception('Impossible d\'ajouter le billet !');
                }
                else {
                    $this->session->set('message', 'Le billet a été créé');
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

    public function editOnePost($postId, Parameter $postForm)
    {
        $article = $this->postDAO->selectOnePost($postId);
        $postForm->set('id', $article->getId());
        $postForm->set('title', $article->getPostTitle());
        $postForm->set('content', $article->getPostContent());
        $postForm->set('author', $article->getPostAuthor());
        $postForm->set('dateFr', $article->getPostDateFr());
        $comments = $this->commentDAO->selectAllCommentsOfOnePost($postId);
        return $this->view->render('editOnePost', [
            'postForm' => $postForm,
            'comments' => $comments
        ]);
    }

    public function refreshOnePost($postId, Parameter $postForm)
    {
        if($postForm->get('submit')) {
            $errors = $this->validation->validate($postForm, 'Post');
            if(!$errors) {
                $affectedLine = $this->postDAO->updateOnePost($postId, $postForm);
                if ($affectedLine === false) {
                    throw new Exception('Impossible de mettre à jour le billet !');
                } else {
                    $this->session->set('message', 'Le billet a été modifié');
                    header('Location: index.php?action=getAllPosts');
                }
            }
            $article = $this->postDAO->selectOnePost($postId);
            $postForm->set('id', $article->getId());
            $postForm->set('dateFr', $article->getPostDateFr());
            return $this->view->render('editOnePost', [
                'postForm' => $postForm,
                'errors' => $errors
            ]);
        }
        return $this->view->render('editOnePost', [
            'postForm' => $postForm
        ]);
    }

    public function removeOnePost ($postId)
    {
        $affectedLines = $this->commentDAO->deleteAllCommentsOfOnePost($postId);
        if ($affectedLines === false) {
            throw new Exception('Impossible de supprimer les commentaires du billet !');
        }
        else {
            $affectedLine = $this->postDAO->deleteOnePost($postId);
            if ($affectedLine === false) {
                throw new Exception('Impossible de supprimer le billet !');
            }
            else {
                $this->session->set('message', 'Le billet a été supprimé');
                header('Location: index.php?action=getAllPosts');
            }
        }
    }

    public function createOneComment($postId, Parameter $commentForm)
    {
        $post = $this->postDAO->selectOnePost($postId);
        $comments = $this->commentDAO->selectAllCommentsOfOnePost($postId);
        if($commentForm->get('submit')) {
            $errors = $this->validation->validate($commentForm, 'Comment');
            if(!$errors) {
                $affectedLines = $this->commentDAO->insertOneComment($postId, $commentForm);
                if ($affectedLines === false) {
                    throw new Exception('Impossible d\'ajouter le commentaire !');
                }
                else {
                    $this->session->set('message', 'Le commentaire a été créé');
                    header('Location: index.php?action=getOnePostAndHisComments&postId=' . $postId);
                }
            }
            return $this->view->render('getOnePostAndHisComments', [
                'post' => $post,
                'comments' => $comments,
                'commentForm' => $commentForm,
                'errors' => $errors
            ]);

        }
        return $this->view->render('getOnePostAndHisComments', [
            'post' => $post,
            'comments' => $comments
        ]);
    }

    public function editOneComment($commentId, $postId)
    {
        $post = $this->postDAO->selectOnePost($postId);
        $comment = $this->commentDAO->selectOneComment($commentId);
        return $this->view->render('editOneComment', [
            'post' => $post,
            'comment' => $comment
        ]);
    }

    public function refreshOneComment($commentId, Parameter $commentForm, $postId)
    {
        $post = $this->postDAO->selectOnePost($postId);
        $comment = $this->commentDAO->selectOneComment($commentId);
        if($commentForm->get('submit')) {
            $errors = $this->validation->validate($commentForm, 'Comment');
            if (!$errors) {
                $affectedLine = $this->commentDAO->updateOneComment($commentId, $commentForm);
                if ($affectedLine === false) {
                    throw new Exception('Impossible de mettre à jour le commentaire !');
                }
                else {
                    $this->session->set('message', 'Le commentaire a été modifié');
                    header('Location: index.php?action=getOnePostAndHisComments&postId=' . $postId);
                }
            }
            return $this->view->render('editOneComment', [
                'post' => $post,
                'comment' => $comment,
                'commentForm' => $commentForm,
                'errors' => $errors
            ]);
        }
        return $this->view->render('editOneComment', [
            'post' => $post,
            'comment' => $comment,
            'commentForm' => $commentForm
        ]);
    }

    public function removeOneComment ($commentId, $postId)
    {
        $affectedLine = $this->commentDAO->deleteOneComment($commentId);
        if ($affectedLine === false) {
            throw new Exception('Impossible de mettre à jour le billet !');
        }
        else {
            $this->session->set('message', 'Le commentaire a été supprimé');
            header('Location: index.php?action=getOnePostAndHisComments&postId=' . $postId);
        }
    }
}
