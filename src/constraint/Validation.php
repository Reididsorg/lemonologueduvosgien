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
        return null;
    }
}
