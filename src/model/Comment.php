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
    private $commentPostId;

    /**
     * @var bool
     */
    private $commentFlag;



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
    public function getCommentPostId()
    {
        return $this->commentPostId;
    }

    /**
     * @param int $commentPostId
     */
    public function setCommentPostId($commentPostId)
    {
        $this->commentPostId = $commentPostId;
    }

    /**
     * @return bool
     */
    public function isCommentFlag()
    {
        return $this->commentFlag;
    }

    /**
     * @param bool $flag
     */
    public function setcommentFlag($commentFlag)
    {
        $this->commentFlag = $commentFlag;
    }

}
