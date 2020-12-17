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
        // Default value of user role : 3 (new)
        $userForm->set('roleId', 3);

        if($userForm->get('submit')) {
            $errors = $this->validation->validate($userForm, 'User');
            if($this->userDAO->checkOneUser($userForm, 'User')) {
                $errors['pseudo'] = $this->userDAO->checkOneUser($userForm);
            }
            if(!$errors){
                $this->userDAO->insertOneUser($userForm);
                $this->sentBySession->set('messageRegister', 'Votre inscription a bien été effectuée :) Votre compte sera activé bientôt !');
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
                $this->sentBySession->set('messageLogin', 'Content de vous revoir '.$result['result']['user_pseudo'].'!');
                $this->sentBySession->set('id', $result['result']['id']);
                $this->sentBySession->set('roleName', $result['result']['roleName']);
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

    public function getBlog()
    {
        $content = 'BLOG';
        return $this->view->render('getBlog', [
            'content' => $content
        ]);
    }

    public function getCv()
    {
        $content = 'CV';
        return $this->view->render('getCv', [
            'content' => $content
        ]);
    }

    public function getContact()
    {
        $content = 'CONTACT';
        return $this->view->render('getContact', [
            'content' => $content
        ]);
    }
}
