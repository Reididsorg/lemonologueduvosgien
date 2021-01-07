<?php

namespace BrunoGrosdidier\Blog\src\Constraint;

use BrunoGrosdidier\Blog\config\Parameter;

class UserValidation extends Validation
{
    private $errors = [];
    private $constraint;

    public function __construct()
    {
        $this->constraint = new Constraint();
    }

    public function check(Parameter $post)
    {
        foreach ($post->all() as $key => $value) {
            $value = $this->constraint->secureInput($value);
            $this->checkField($key, $value);
        }
        return $this->errors;
    }

    private function checkField($name, $value)
    {
        if($name === 'pseudo') {
            $error = $this->checkPseudo($name, $value);
            $this->addError($name, $error);
        }
        elseif ($name === 'email') {
            $error = $this->checkEmailAdress($name, $value);
            $this->addError($name, $error);
        }
        elseif ($name === 'password') {
            $error = $this->checkPassword($name, $value);
            $this->addError($name, $error);
        }
    }

    private function addError($name, $error) {
        if($error) {
            $this->errors += [
                $name => $error
            ];
        }
    }

    private function checkPseudo($name, $value)
    {
        if($this->constraint->notBlank($name, $value)) {
            return $this->constraint->notBlank('Pseudo', $value);
        }
        if($this->constraint->minLength($name, $value, 2)) {
            return $this->constraint->minLength('Pseudo', $value, 2);
        }
        if($this->constraint->maxLength($name, $value, 255)) {
            return $this->constraint->maxLength('Pseudo', $value, 255);
        }
    }

    private function checkEmailAdress($name, $value)
    {
        if($this->constraint->notBlank($name, $value)) {
            return $this->constraint->notBlank('Email', $value);
        }
        if($this->constraint->minLength($name, $value, 2)) {
            return $this->constraint->minLength('Email', $value, 2);
        }
        if($this->constraint->maxLength($name, $value, 255)) {
            return $this->constraint->maxLength('Email', $value, 255);
        }
        if($this->constraint->isValidEmailAdress($name, $value)) {
            return $this->constraint->isValidEmailAdress('Email', $value);
        }
        return null;
    }

    private function checkPassword($name, $value)
    {
        if($this->constraint->notBlank($name, $value)) {
            return $this->constraint->notBlank('Mot de passe', $value);
        }
        if($this->constraint->minLength($name, $value, 5)) {
            return $this->constraint->minLength('Mot de passe', $value, 5);
        }
        if($this->constraint->maxLength($name, $value, 255)) {
            return $this->constraint->maxLength('Mot de passe', $value, 255);
        }
    }
}
