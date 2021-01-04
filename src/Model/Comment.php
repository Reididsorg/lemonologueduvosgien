<?php

namespace BrunoGrosdidier\Blog\src\Model;

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
     * @var int
     */
    private $commentFlag;

    /**
     * @var int
     */
    private $commentNew;



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
     * @param int $commentFlag
     */
    public function setcommentFlag($commentFlag)
    {
        $this->commentFlag = $commentFlag;
    }

    /**
     * @return bool
     */
    public function isCommentNew()
    {
        return $this->commentNew;
    }

    /**
     * @param int $commentNew
     */
    public function setcommentNew($commentNew)
    {
        $this->commentNew = $commentNew;
    }

}
