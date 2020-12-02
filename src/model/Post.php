<?php

namespace BrunoGrosdidier\Blog\src\model;

class Post
{
    /**
     * @var int
     */
    private $id;
    /**
     * @var string
     */
    private $postTitle;
    /**
     * @var string
     */
    private $postContent;
    /**
     * @var string
     */
    //private $author;
    /**
     * @var \DateTime
     */
    private $postDateFr;


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
    public function getPostTitle()
    {
        return $this->postTitle;
    }
    /**
     * @param string $postTitle
     */
    public function setPostTitle($postTitle)
    {
        $this->postTitle = $postTitle;
    }
    /**
     * @return string
     */
    public function getPostContent()
    {
        return $this->postContent;
    }
    /**
     * @param string $postContent
     */
    public function setPostContent($postContent)
    {
        $this->postContent = $postContent;
    }
    /**
     * @return string
     */
    /*public function getAuthor()
    {
        return $this->postAuthor;
    }*/
    /**
     * @param string $postAuthor
     */
    /*public function setAuthor($postAuthor)
    {
        $this->postAuthor = $postAuthor;
    }*/
    /**
     * @return \DateTime
     */
    public function getPostDateFr()
    {
        return $this->postDateFr;
    }
    /**
     * @param \DateTime $postDateFr
     */
    public function setPostDateFr($postDateFr)
    {
        $this->postDateFr = $postDateFr;
    }
}