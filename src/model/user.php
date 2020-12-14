<?php

namespace BrunoGrosdidider\Blog\src\model;

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
    private $userCreatedAt;




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
    public function getUserCreatedAt()
    {
        return $this->userCreatedAt;
    }

    /**
     * @param \DateTime $userCreatedAt
     */
    public function setUserCreatedAt($userCreatedAt)
    {
        $this->userCreatedAt = $userCreatedAt;
    }
}