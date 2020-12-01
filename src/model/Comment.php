<?php

namespace BrunoGrosdidier\Blog\src\model;

class Comment
{
    /**
     * @var int
     */
    private $id;
    /**
     * @var string
     */
    private $commentAuthor;
    /**
     * @var string
     */
    private $commentContent;
    /**
     * @var \DateTime
     */
    private $commentDateFr;
    /**
     * @var int
     */
    private $postId;



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
    public function getCommentAuthor()
    {
        return $this->commentAuthor;
    }
    /**
     * @param string $commentAuthor
     */
    public function setCommentAuthor($commentAuthor)
    {
        $this->commentAuthor = $commentAuthor;
    }

    /**
     * @return string
     */
    public function getCommentContent()
    {
        return $this->commentContent;
    }
    /**
     * @param string $commentContent
     */
    public function setCommentContent($commentContent)
    {
        $this->commentContent = $commentContent;
    }

    /**
     * @return \DateTime
     */
    public function getCommentDateFr()
    {
        return $this->commentDateFr;
    }
    /**
     * @param \DateTime $commentDateFr
     */
    public function setCommentDateFr($commentDateFr)
    {
        $this->commentDateFr = $commentDateFr;
    }

    /**
     * @return int
     */
    public function getPostId()
    {
        return $this->postId;
    }
    /**
     * @param int $postId
     */
    public function setPostId($postId)
    {
        $this->postId = $postId;
    }

}
