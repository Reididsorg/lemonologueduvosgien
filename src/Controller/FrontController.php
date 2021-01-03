<?php

namespace BrunoGrosdidier\Blog\src\Controller;

use BrunoGrosdidier\Blog\config\Parameter;

class FrontController extends Controller
{
    public function getAllPosts()
    {
        $pagination = $this->pagination->paginate(2, $this->sentByGet->get('page'), $this->postDAO->countAllPosts());
        $posts = $this->postDAO->selectAllPosts($pagination->getLimit(), $this->pagination->getStart());
        return $this->render('front/getAllPosts.html.twig', [
            'posts' => $posts,
            'pagination'=>$pagination
        ]);
    }

    public function getOnePostAndHisComments($postId)
    {
        $post = $this->postDAO->selectOnePost($postId);
        $pagination = $this->pagination->paginate(3, $this->sentByGet->get('page'), $this->commentDAO->countAllComments($postId));
        $comments = $this->commentDAO->selectAllCommentsOfOnePost($postId, $pagination->getLimit(), $pagination->getStart());
        return $this->render('front/getOnePostAndHisComments.html.twig', [
            'post' => $post,
            'comments' => $comments,
            'pagination' => $pagination,
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
            return $this->render('front/register.html.twig', [
                'userForm'=>$userForm,
                'errors'=>$errors
            ]);
        }
        return $this->render('front/register.html.twig');
    }

    public function login(Parameter $userForm) {
        if($userForm->get('submit')) {
            $result = $this->userDAO->login($userForm);
            if($result && $result['isPasswordValid']) {
                $this->sentBySession->set('messageLogin', 'Content de vous revoir '.$result['result']['user_pseudo'].'!');
                $this->sentBySession->set('id', $result['result']['id']);
                $this->sentBySession->set('roleName', $result['result']['roleName']);
                $this->sentBySession->set('pseudo', $userForm->get('pseudo'));
                // Redirection in terms of role name (admin or not)
                if($result['result']['roleName'] === 'admin') {
                    header('Location: index.php?action=getAdmin');
                }
                else {
                    header('Location: index.php?action=getAllPosts');
                }
            }
            else {
                $this->sentBySession->set('error_login', 'Le pseudo ou le mot de passe sont incorrects');
                return $this->render('front/login.html.twig', [
                    'userForm'=> $userForm
                ]);
            }
        }
        return $this->render('front/login.html.twig');
    }

    public function getBlog()
    {
        $content = 'BLOG';
        return $this->render('front/getBlog.html.twig', [
            'content' => $content
        ]);
    }

    public function getCv()
    {
        $content = 'CV';
        return $this->render('front/getCv.html.twig', [
            'content' => $content
        ]);
    }

    public function getContact()
    {
        $content = 'CONTACT';
        return $this->render('front/getContact.html.twig', [
            'content' => $content
        ]);
    }
}