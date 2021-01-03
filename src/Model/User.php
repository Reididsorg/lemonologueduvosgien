<?php

namespace BrunoGrosdidier\Blog\src\Model;

class User
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $userPseudo;

    /**
     * @var string
     */
    private $userPassword;

    /**
     * @var \DateTime
     */
    private $userCreatedAtFr;

    /**
     * @var int
     */
    private $roleId;

    /**
     * @var string
     */
    private $roleName;




    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }


    /**
     * @return string
     */
    public function getUserPseudo()
    {
        return $this->userPseudo;
    }

    /**
     * @param string $userPseudo
     */
    public function setUserPseudo($userPseudo)
    {
        $this->userPseudo = $userPseudo;
    }


    /**
     * @return string
     */
    public function getUserPassword()
    {
        return $this->userPassword;
    }

    /**
     * @param string $userPassword
     */
    public function setUserPassword($userPassword)
    {
        $this->userPassword = $userPassword;
    }


    /**
     * @return \DateTime
     */
    public function getUserCreatedAtFr()
    {
        return $this->userCreatedAtFr;
    }

    /**
     * @param \DateTime $userCreatedAtFr
     */
    public function setUserCreatedAtFr($userCreatedAtFr)
    {
        $this->userCreatedAtFr = $userCreatedAtFr;
    }


    /**
     * @return int
     */
    public function getRoleId()
    {
        return $this->roleId;
    }

    /**
     * @param int $roleId
     */
    public function setRoleId($roleId)
    {
        $this->roleId = $roleId;
    }


    /**
     * @return string
     */
    public function getRoleName()
    {
        return $this->roleName;
    }

    /**
     * @param string $roleName
     */
    public function setRoleName($roleName)
    {
        $this->roleName = $roleName;
    }
}
