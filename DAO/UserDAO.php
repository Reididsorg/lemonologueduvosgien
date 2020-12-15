<?php

namespace BrunoGrosdidier\Blog\DAO;

use BrunoGrosdidier\Blog\config\Parameter;
//use BrunoGrosdidier\Blog\src\model\User;

class UserDAO extends DAO
{
    public function createUser (Parameter $userForm)
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

    public function checkOneUser (Parameter $user)
    {
        $request = 'SELECT 
                        COUNT(user_pseudo) 
                    FROM 
                        user 
                    WHERE 
                        user_pseudo = :pseudo';
        $result = $this->createQuery($request, [
            'pseudo'=>$user->get('pseudo')
        ]);
        $isUnique = $result->fetchColumn();
        if($isUnique) {
            return '<p>Le pseudo existe déjà</p>';
        }
    }

    public function login (Parameter $user)
    {
        $request = 'SELECT 
                    id, 
                    user_password 
                FROM 
                    user 
                WHERE 
                    user_pseudo = :pseudo';
        $data = $this->createQuery($request, [
            'pseudo'=>$user->get('pseudo')
        ]);
        $result = $data->fetch();
        if ($result) {
            $isPasswordValid = password_verify($user->get('password'), $result['user_password']);
            return [
                'result' => $result,
                'isPasswordValid' => $isPasswordValid
            ];
        }
        return null;
    }

    public function updatePassword (Parameter $user, $pseudo)
    {
        $request = 'UPDATE 
                        user 
                    SET
                        user_password = :password
                    WHERE
                        user_pseudo = :pseudo';
        $this->createQuery($request, [
            'password'=>password_hash($user->get('password'), PASSWORD_BCRYPT),
            'pseudo'=>$pseudo
        ]);
    }

    public function deleteOneUser ($pseudo)
    {
        $request = 'DELETE FROM
                        user
                    WHERE
                        user_pseudo = :pseudo';
        $this->createQuery($request, [
            'pseudo'=>$pseudo
        ]);
    }
}
