<?php

namespace BrunoGrosdidier\Blog\src\Constraint;

use BrunoGrosdidier\Blog\config\Parameter;

class ContactValidation extends Validation
{
    private $errors = [];
    private $constraint;

    public function __construct()
    {
        $this->constraint = new Constraint();
    }

    public function check(Parameter $data)
    {
        foreach ($data->all() as $key => $value) {
            $value = $this->constraint->secureInput($value);
            $this->checkField($key, $value);
        }
        return $this->errors;
    }

    private function checkField($name, $value)
    {
        if($name === 'expediteur') {
            $error = $this->checkEmailExpeditor($name, $value);
            $this->addError($name, $error);
        }
        elseif ($name === 'email') {
            $error = $this->checkEmailAdress($name, $value);
            $this->addError($name, $error);
        }
        elseif ($name === 'message') {
            $error = $this->checkEmailMessage($name, $value);
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

    private function checkEmailExpeditor($name, $value)
    {
        if($this->constraint->notBlank($name, $value)) {
            return $this->constraint->notBlank('expediteur', $value);
        }
        if($this->constraint->minLength($name, $value, 2)) {
            return $this->constraint->minLength('expediteur', $value, 2);
        }
        if($this->constraint->maxLength($name, $value, 255)) {
            return $this->constraint->maxLength('expediteur', $value, 255);
        }
        return null;
    }

    private function checkEmailAdress($name, $value)
    {
        if($this->constraint->notBlank($name, $value)) {
            return $this->constraint->notBlank('email', $value);
        }
        if($this->constraint->minLength($name, $value, 2)) {
            return $this->constraint->minLength('email', $value, 2);
        }
        if($this->constraint->maxLength($name, $value, 255)) {
            return $this->constraint->maxLength('email', $value, 255);
        }
        if($this->constraint->isValidEmailAdress($name, $value)) {
            return $this->constraint->isValidEmailAdress('email', $value);
        }
        return null;
    }

    private function checkEmailMessage($name, $value)
    {
        if($this->constraint->notBlank($name, $value)) {
            return $this->constraint->notBlank('message', $value);
        }
        if($this->constraint->minLength($name, $value, 2)) {
            return $this->constraint->minLength('message', $value, 2);
        }
        return null;
    }
}
