<?php

namespace BrunoGrosdidier\Blog\src\Controller;

use BrunoGrosdidier\Blog\config\Parameter;

use BrunoGrosdidier\Blog\vendor\swiftmailer\swiftmailer\lib\classes\Swift\SmtpTransport;

class FrontController extends Controller
{
    public function getHome()
    {
        $content = 'Bienvenue sur l\'espace de Bruno Grosdidier !';
        return $this->render('front/getHome.html.twig', [
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
        $pagination = $this->pagination->paginate(3, $this->sentByGet->get('page'), $this->commentDAO->countAllValidCommentsOfOnePost($postId));
        $comments = $this->commentDAO->selectAllValidCommentsOfOnePost($postId, $pagination->getLimit(), $pagination->getStart());
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
                // Send confirmation to user by email
                $userEmail = $userForm->get('email');
                $userName = $userForm->get('pseudo');
                $subjectToUser = 'Bienvenue au Monologue du Vosgien';
                $messageToUser = 'Bonjour '.ucfirst($userForm->get('pseudo')).' !
                <p>Votre inscription au MONOLOGUE DU VOSGIEN a été enregistrée ! :)<br>
                Vous recevrez bientôt un message confirmant l\'activation de votre compte.<br>
                Vous pourrez alors publier des commentaires sur le site.<br>
                A bientôt !</p>
                <p>Bruno</p>';
                $sendEmail = $this->sendEmailToUser($userEmail, $userName, $subjectToUser, $messageToUser);
                if($sendEmail === 1) {
                    $this->sentBySession->set('messageRegister', 'Votre inscription a bien été effectuée :) 
                    Un courriel de confirmation vient de vous être envoyé !');
                    header('Location: index.php');
                }
                else {
                    $this->sentBySession->set('messageRegister', 'Problème avec l\'envoi du message :(');
                    return $this->render('front/register.html.twig');
                }
            }
            else {
                return $this->render('front/register.html.twig', [
                    'userForm'=>$userForm,
                    'errors'=>$errors
                ]);
            }
        }
        else {
            return $this->render('front/register.html.twig');
        }
    }

    public function login(Parameter $userForm) {
        if($userForm->get('submit')) {
            $result = $this->userDAO->login($userForm);
            if($result && $result['isPasswordValid']) {
                $this->sentBySession->set('messageLogin', 'Content de vous revoir '.$result['result']['user_pseudo'].'!');
                $this->sentBySession->set('id', $result['result']['id']);
                $this->sentBySession->set('roleName', $result['result']['roleName']);
                $this->sentBySession->set('email', $result['result']['user_email']);
                $this->sentBySession->set('pseudo', $userForm->get('pseudo'));
                // Redirection in terms of role name (admin or not)
                if($result['result']['roleName'] === 'admin') {
                    header('Location: index.php?action=getAdmin');
                }
                else {
                    header('Location: index.php');
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

    public function submitContactForm(Parameter $contactForm)
    {
        if($contactForm->get('submit')) {
            $errors = $this->validation->validate($contactForm, 'Contact');
            if(!$errors){
                // Verify Recaptcha
                $verifyRecaptcha = $this->recaptcha->verifyRecaptcha($contactForm->get('recaptcha-response'));
                if($verifyRecaptcha === 'success') {
                    // Send message to me by email
                    $subjectToMe = 'Nouveau message de contact';
                    $messageToMe = '<p><strong>De : </strong><br>'.$contactForm->get('expediteur').'</p>
                <p><strong>Email : </strong><br>'.$contactForm->get('email').'</p>
                <p><strong>Message : </strong><br>
                '.nl2br($contactForm->get('message')).'</p>';
                    $sendEmail = $this->sendEmailToMe($subjectToMe, $messageToMe);
                    if($sendEmail === 1) {
                        $this->sentBySession->set('messageSendEmail', 'Votre message a bien été envoyé :)');
                        return $this->render('front/getContact.html.twig');
                    }
                    else {
                        $this->sentBySession->set('messageSendEmail', 'Problème avec l\'envoi du message :(');
                        return $this->render('front/getContact.html.twig');
                    }
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
