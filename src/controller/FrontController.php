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

    public function register(Parameter $userForm)
    {

        if($userForm->get('submit')) {
            $errors = $this->validation->validate($userForm, 'User');
            if($this->userDAO->checkOneUser($userForm, 'User')) {
                $errors['pseudo'] = $this->userDAO->checkOneUser($userForm);
            }
            if(!$errors){
                $this->userDAO->createUser($userForm);
                $this->sentBySession->set('messageRegister', 'Votre inscription a bien été effectuée');
                header('Location: index.php?action=getAllPosts');
            }
            return $this->view->render('register', [
                'userForm'=>$userForm,
                'errors'=>$errors
            ]);
        }
        return $this->view->render('register');
    }

    public function login(Parameter $userForm) {
        if($userForm->get('submit')) {
            $result = $this->userDAO->login($userForm);
            if($result && $result['isPasswordValid']) {
                $this->sentBySession->set('messageLogin', 'Content de vous revoir !');
                $this->sentBySession->set('id', $result['result']['id']);
                $this->sentBySession->set('pseudo', $userForm->get('pseudo'));
                header('Location: index.php?action=getAllPosts');
            }
            else {
                $this->sentBySession->set('error_login', 'Le pseudo ou le mot de passe sont incorrects');
                return $this->view->render('login', [
                    'userForm'=> $userForm
                ]);
            }
        }
        return $this->view->render('login');
    }
}
