<?php

namespace BrunoGrosdidier\Blog\src\Constraint;

class Constraint
{
    public function notBlank($name, $value)
    {
        if(empty($value)) {
            return 'Le champ '.$name.' saisi est vide';
        }
        return null;
    }

    public function minLength($name, $value, $minSize)
    {
        if(strlen($value) < $minSize) {
            return 'Le champ '.$name.' doit contenir au moins '.$minSize.' caractères';
        }
        return null;
    }

    public function maxLength($name, $value, $maxSize)
    {
        if(strlen($value) > $maxSize) {
            return 'Le champ '.$name.' doit contenir au maximum '.$maxSize.' caractères';
        }
        return null;
    }
}
