<?php

namespace BrunoGrosdidier\Blog\src\Constraint;

class Validation
{
    public function validate($data, $name)
    {
        // 'Post' désigne un billet de blog
        if($name === 'Post') {
            $postValidation = new PostValidation();
            return $postValidation->check($data);
        }

        // 'Comment' désigne un commentaire
        if($name === 'Comment') {
            $commentValidation = new CommentValidation();
            return $commentValidation->check($data);
        }

        // 'User' désigne un utilisateur
        if($name === 'User') {
            $userValidation = new UserValidation();
            return $userValidation->check($data);
        }

        return null;
    }
}
