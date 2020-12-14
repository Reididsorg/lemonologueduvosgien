<?php

namespace BrunoGrosdidier\Blog\DAO;

use BrunoGrosdidier\Blog\config\Parameter;
//use BrunoGrosdidier\Blog\src\model\User;

class UserDAO extends DAO
{
    public function insertOneUser(Parameter $userForm)
    {
        $request = 'INSERT INTO user 
                        (user_pseudo, 
                         user_password, 
                         user_created_at) 
                    VALUES 
                        (:pseudo, 
                         :password, 
                         NOW())';
        $this->createQuery($request, [
            'pseudo'=>$userForm->get('pseudo'),
            'password'=>password_hash($userForm->get('password'), PASSWORD_BCRYPT)
        ]);
    }

    public function checkOneUser(Parameter $user)
    {
        $request = 'SELECT COUNT(user_pseudo) FROM user WHERE user_pseudo = :pseudo';
        $result = $this->createQuery($request, [
            'pseudo'=>$user->get('pseudo')
        ]);
        $isUnique = $result->fetchColumn();
        if($isUnique) {
            return '<p>Le pseudo existe déjà</p>';
        }
    }
}
