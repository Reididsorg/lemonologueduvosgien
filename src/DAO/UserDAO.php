<?php

namespace BrunoGrosdidier\Blog\src\DAO;

use BrunoGrosdidier\Blog\config\Parameter;
use BrunoGrosdidier\Blog\src\Model\User;

class UserDAO extends DAO
{
    private function buildObject($row)
    {
        $user = new User();
        $user->setId($row['id']);
        $user->setUserPseudo($row['user_pseudo']);
        $user->setUserEmail($row['user_email']);
        $user->setUserCreatedAtFr($row['user_created_at_fr']);
        $user->setRoleName($row['role_name']);
        return $user;
    }

    public function insertOneUser(Parameter $userForm)
    {
        $request = 'INSERT INTO user 
                        (user_pseudo,
                         user_email,
                         user_password, 
                         user_created_at,
                         role_id) 
                    VALUES 
                        (:pseudo,
                         :email,
                         :password, 
                         NOW(),
                         :roleId)';
        $this->createQuery($request, [
            'pseudo' => $userForm->get('pseudo'),
            'email' => $userForm->get('email'),
            'password' => password_hash($userForm->get('password'), PASSWORD_BCRYPT),
            'roleId' => $userForm->get('roleId')
        ]);
    }

    public function checkOneUser(Parameter $user)
    {
        $request = 'SELECT 
                        COUNT(user_pseudo) 
                    FROM 
                        user 
                    WHERE 
                        user_pseudo = :pseudo';
        $result = $this->createQuery($request, [
            'pseudo' => $user->get('pseudo')
        ]);
        $isUnique = $result->fetchColumn();
        if ($isUnique) {
            return '<p>Le pseudo existe déjà</p>';
        }
    }

    public function login(Parameter $user)
    {
        $request = 'SELECT 
                    user.id,
                    user_pseudo,
                    user_email,
                    user.user_password,
                    role.role_name AS roleName
                FROM 
                    user
                LEFT JOIN role
                    ON role.id = user.role_id
                WHERE 
                    user.user_pseudo = :pseudo';
        $data = $this->createQuery($request, [
            'pseudo' => $user->get('pseudo')
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

    public function updatePassword(Parameter $user, $pseudo)
    {
        $request = 'UPDATE 
                        user 
                    SET
                        user_password = :password
                    WHERE
                        user_pseudo = :pseudo';
        $this->createQuery($request, [
            'password' => password_hash($user->get('password'), PASSWORD_BCRYPT),
            'pseudo' => $pseudo
        ]);
    }

    public function deleteCurrentUser($pseudo)
    {
        $request = 'DELETE FROM
                        user
                    WHERE
                        user_pseudo = :pseudo';
        $this->createQuery($request, [
            'pseudo' => $pseudo
        ]);
    }

    public function deleteSpecificUser($userId)
    {
        $request = 'DELETE FROM
                        user
                    WHERE
                        id = :userId';
        $this->createQuery($request, [
            'userId' => $userId
        ]);
    }

    public function getAllUsers()
    {
        $request = 'SELECT 
                    user.id, 
                    user.user_pseudo,
                    user.user_email,
                    DATE_FORMAT(user.user_created_at, \'%d/%m/%Y à %Hh%i\') AS user_created_at_fr,
                    role.role_name 
                FROM 
                    user 
                INNER JOIN role 
                    ON role.id = user.role_id
                ORDER BY user.id DESC';
        $result = $this->createQuery($request);
        $users = [];
        foreach ($result as $row) {
            $userId = $row['id'];
            $users[$userId] = $this->buildObject($row);
        }
        $result->closeCursor();
        return $users;
    }

    public function activateSpecificUser($userId)
    {
        $request = 'UPDATE 
                        user
                    SET 
                        role_id = :roleId
                    WHERE
                        id = :userId
                    ';
        // roleId = 2 (Editor)
        $this->createQuery($request, [
            'roleId' => 2,
            'userId' => $userId
        ]);
    }

    public function getOneUserInfos($userId)
    {
        $request = 'SELECT 
                    user.id,
                    user_pseudo,
                    user_email,
                    DATE_FORMAT(user.user_created_at, \'%d/%m/%Y à %Hh%i\') AS user_created_at_fr,
                    role.role_name
                FROM 
                    user
                LEFT JOIN role
                    ON role.id = user.role_id
                WHERE 
                   user.id = :userId';
        $data = $this->createQuery($request, [
            'userId' => $userId
        ]);
        $userInfos = $data->fetch();
        $data->closeCursor();
        return $this->buildObject($userInfos);
    }
}
