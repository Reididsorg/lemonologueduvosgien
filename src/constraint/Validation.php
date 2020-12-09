<?php

namespace BrunoGrosdidier\Blog\src\constraint;

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

        return null;
    }
}
