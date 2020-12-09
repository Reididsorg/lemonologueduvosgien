<?php

namespace BrunoGrosdidier\Blog\src\controller;

use BrunoGrosdidier\Blog\config\Parameter;

class BackController extends Controller
{
    public function addOnePost()
    {
        return $this->view->render('addOnePost');
    }

    public function createOnePost(Parameter $post)
    {
        if($post->get('submit')) {
            $errors = $this->validation->validate($post, 'Post');
            if(!$errors) {
                $affectedLines = $this->postDAO->insertOnePost($post);
                if ($affectedLines === false) {
                    throw new Exception('Impossible d\'ajouter le billet !');
                }
                else {
                    $this->session->set('message', 'Le billet a été créé');
                    header('Location: index.php?action=getAllPosts');
                }
            }
            return $this->view->render('addOnePost', [
                'post' => $post,
                'errors' => $errors
            ]);
        }
        return $this->view->render('addOnePost', [
            'post' => $post
        ]);
    }

    public function editOnePost($postId, Parameter $post)
    {
        $article = $this->postDAO->selectOnePost($postId);
        $post->set('id', $article->getId());
        $post->set('title', $article->getPostTitle());
        $post->set('content', $article->getPostContent());
        $post->set('author', $article->getPostAuthor());
        $post->set('dateFr', $article->getPostDateFr());
        $comments = $this->commentDAO->selectAllCommentsOfOnePost($postId);
        return $this->view->render('editOnePost', [
            'post' => $post,
            'comments' => $comments
        ]);
    }

    public function refreshOnePost($postId, Parameter $post)
    {
        if($post->get('submit')) {
            $errors = $this->validation->validate($post, 'Post');
            if(!$errors) {
                $affectedLine = $this->postDAO->updateOnePost($postId, $post);
                if ($affectedLine === false) {
                    throw new Exception('Impossible de mettre à jour le billet !');
                } else {
                    $this->session->set('message', 'Le billet a été modifié');
                    header('Location: index.php?action=getAllPosts');
                }
            }
            $article = $this->postDAO->selectOnePost($postId);
            $post->set('id', $article->getId());
            $post->set('dateFr', $article->getPostDateFr());
            return $this->view->render('editOnePost', [
                'post' => $post,
                'errors' => $errors
            ]);
        }
        return $this->view->render('editOnePost', [
            'post' => $post
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

    public function createOneComment($postId, Parameter $formData)
    {
        $post = $this->postDAO->selectOnePost($postId);
        $comments = $this->commentDAO->selectAllCommentsOfOnePost($postId);
        if($formData->get('submit')) {
            $errors = $this->validation->validate($formData, 'Comment');
            if(!$errors) {
                $affectedLines = $this->commentDAO->insertOneComment($postId, $formData);
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
                'formData' => $formData,
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

    public function refreshOneComment($commentId, Parameter $formData, $postId)
    {
        $post = $this->postDAO->selectOnePost($postId);
        $comment = $this->commentDAO->selectOneComment($commentId);
        if($formData->get('submit')) {
            $errors = $this->validation->validate($formData, 'Comment');
            if (!$errors) {
                $affectedLine = $this->commentDAO->updateOneComment($commentId, $formData);
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
                'formData' => $formData,
                'errors' => $errors
            ]);
        }
        return $this->view->render('editOneComment', [
            'post' => $post,
            'comment' => $comment,
            'formData' => $formData
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
