<?php

namespace BrunoGrosdidier\Blog\src\controller;

use BrunoGrosdidier\Blog\config\Parameter;

class FrontController extends Controller
{
    public function getAllPosts()
    {
        $posts = $this->postDAO->selectAllPosts();
        return $this->view->render('getAllPosts', [
            'posts' => $posts
        ]);
    }

    public function getOnePostAndHisComments($postId)
    {
        $post = $this->postDAO->selectOnePost($postId);
        $comments = $this->commentDAO->selectAllCommentsOfOnePost($postId);
        return $this->view->render('getOnePostAndHisComments', [
            'post' => $post,
            'comments' => $comments
        ]);
    }

    public function createOneUser(Parameter $userForm)
    {

        if($userForm->get('submit')) {
            $errors = $this->validation->validate($userForm, 'User');
            if($this->userDAO->checkOneUser($userForm, 'User')) {
                $errors['pseudo'] = $this->userDAO->checkOneUser($userForm);
            }
            if(!$errors){
                $this->userDAO->insertOneUser($userForm);
                $this->sentBySession->set('messageCreateOneUser', 'Votre inscription a bien été effectuée');
                header('Location: index.php?action=getAllPosts');
            }
            return $this->view->render('editOneUser', [
                'userForm'=>$userForm,
                'errors'=>$errors
            ]);
        }
        return $this->view->render('editOneUser');
    }
}
