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
            $affectedLines = $this->postDAO->insertOnePost($post);
            if ($affectedLines === false) {
                throw new Exception('Impossible d\'ajouter le billet !');
            }
            else {
                $this->session->set('message', 'Le billet a été créé');
                header('Location: index.php?action=getAllPosts');
            }
        }
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

    public function refreshOnePost($postId, Parameter $post)
    {
        if($post->get('submit')) {
            $affectedLine = $this->postDAO->updateOnePost($postId, $post);
            if ($affectedLine === false) {
                throw new Exception('Impossible de mettre à jour le billet !');
            } else {
                $this->session->set('message', 'Le billet a été modifié');
                header('Location: index.php?action=getAllPosts');
            }
        }
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

    public function createOneComment($postId, Parameter $post)
    {
        $affectedLines = $this->commentDAO->insertOneComment($postId, $post);
        if ($affectedLines === false) {
            throw new Exception('Impossible d\'ajouter le commentaire !');
        }
        else {
            $this->session->set('message', 'Le commentaire a été créé');
            header('Location: index.php?action=getOnePostAndHisComments&postId=' . $postId);
        }
    }

    public function editOneComment($commentId, $postId)
    {
        $comment = $this->commentDAO->selectOneComment($commentId);
        $post = $this->postDAO->selectOnePost($postId);
        return $this->view->render('editOneComment', [
            'post' => $post,
            'comment' => $comment
        ]);
    }

    public function refreshOneComment($commentId, Parameter $post, $postId)
    {
        $affectedLine = $this->commentDAO->updateOneComment($commentId, $post);
        if ($affectedLine === false) {
            throw new Exception('Impossible de mettre à jour le commentaire !');
        }
        else {
            $this->session->set('message', 'Le commentaire a été modifié');
            header('Location: index.php?action=getOnePostAndHisComments&postId=' . $postId);
        }
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
