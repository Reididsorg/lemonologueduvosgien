<?php

namespace BrunoGrosdidier\Blog\src\Controller;

use BrunoGrosdidier\Blog\config\Parameter;

use BrunoGrosdidier\Blog\vendor\swiftmailer\swiftmailer\lib\classes\Swift\SmtpTransport;

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

    public function submitContactForm(Parameter $contactForm)
    {
        if($contactForm->get('submit')) {
            $errors = $this->validation->validate($contactForm, 'Contact');
            if(!$errors){

                // Envoyer le message par email
                // Create the Transport
                //$transport = (new Swift_SmtpTransport(EMAIL_HOST, EMAIL_PORT))
                $transport = (new \Swift_SmtpTransport(EMAIL_HOST, EMAIL_PORT))
                    ->setUsername(EMAIL_USERNAME)
                    ->setPassword(EMAIL_PASSWORD)
                    ->setEncryption(EMAIL_ENCRYPTION) //For Gmail
                ;

                // Create the Mailer using your created Transport
                //$mailer = new Swift_Mailer($transport);
                $mailer = (new \Swift_Mailer($transport));

                // Create a message
                //$message = (new Swift_Message('Message du monologueduvosgien'))
                $message = (new \Swift_Message(EMAIL_SUBJECT))
                    ->setFrom([$contactForm->get('email') => $contactForm->get('expediteur')])
                    ->setTo([EMAIL_DEST_1, EMAIL_DEST_2 => EMAIL_DEST_NAME])
                    ->setBody($contactForm->get('message'))
                ;

                // Send the message
                $result = $mailer->send($message);

                if($result === 1) {
                    $this->sentBySession->set('messageContact', 'Votre message a bien été envoyé :)');
                    return $this->render('front/getContact.html.twig');
                }
                else {
                    $this->sentBySession->set('messageContact', 'Problème avec l\'envoi du message :(');
                    return $this->render('front/getContact.html.twig');
                }

            }
            else {
                return $this->render('front/getContact.html.twig', [
                    'contactForm'=>$contactForm,
                    'errors'=>$errors
                ]);
            }
        }
        return $this->render('front/getContact.html.twig');
    }
}
