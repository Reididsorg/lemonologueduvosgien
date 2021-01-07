<?php

namespace BrunoGrosdidier\Blog\src\DAO;

use BrunoGrosdidier\Blog\config\Parameter;
use BrunoGrosdidier\Blog\src\Model\Comment;

class CommentDAO extends DAO
{
    private function buildObject($row)
    {
        $comment = new Comment();
        if(isset($row['id'])){
            $comment->setId($row['id']);
        }
        if(isset($row['comment_author'])){
            $comment->setCommentAuthor($row['comment_author']);
        }
        if(isset($row['comment_content'])){
            $comment->setCommentContent($row['comment_content']);
        }
        if(isset($row['comment_date_fr'])){
            $comment->setCommentDateFr($row['comment_date_fr']);
        }
        if(isset($row['comment_post_id'])){
            $comment->setCommentPostId($row['comment_post_id']);
        }
        if(isset($row['comment_new'])){
            $comment->setCommentNew($row['comment_new']);
        }
        if(isset($row['comment_flag'])){
            $comment->setCommentFlag($row['comment_flag']);
        }
        return $comment;
    }

    public function countAllValidCommentsOfOnePost($postId)
    {
        $request = 'SELECT 
                        COUNT(*) 
                    FROM 
                        comment 
                    WHERE 
                        comment_post_id = :postId
                    AND
                        comment_new = :commentNew';
        return $this->createQuery($request, [
            'postId'=>$postId,
            'commentNew'=>0,
        ])->fetchColumn();
    }

	public function selectAllValidCommentsOfOnePost($postId, $limit = null, $start = null)
	{
        $request = 'SELECT 
                        id, 
                        comment_author, 
                        comment_content, 
                        DATE_FORMAT(comment_date, \'%d/%m/%Y à %Hh%i\') AS comment_date_fr, 
                        comment_post_id,
                        comment_flag,
                        comment_new
                    FROM 
                        comment 
                    WHERE 
                        comment_post_id = :postId
                    AND
                        comment_new = :commentNew
                    ORDER BY comment_date DESC';
        if($limit) {
            $request .= ' LIMIT '.$limit.' OFFSET '.$start;
        }
        $result = $this->createQuery($request, [
            'postId'=>$postId,
            'commentNew'=>0
        ]);
        $comments = [];
        foreach($result as $row){
            $commentId = $row['id'];
            $comments[$commentId] = $this->buildObject($row);
        }
        $result->closeCursor();
        return $comments;
	}

	public function selectOneComment($commentId)
	{
        $request = 'SELECT 
                        id, 
                        comment_author, 
                        comment_content, 
                        DATE_FORMAT(comment_date, \'%d/%m/%Y à %Hh%i\') AS comment_date_fr,
                        comment_post_id,
                        comment_flag
                    FROM 
                        comment 
                    WHERE 
                        id = :commentId';
        $result = $this->createQuery($request, [
            'commentId'=>$commentId
        ]);
        $comment = $result->fetch();
        $result->closeCursor();
        return $this->buildObject($comment);
	}

    public function insertOneComment($postId, Parameter $post, $commentIsNew)
    {
        $request = 'INSERT INTO comment 
                        (comment_author, 
                         comment_content, 
                         comment_date,
                         comment_post_id,
                         comment_flag,
                         comment_new)
                    VALUES
                        (:comment_author,
                         :comment_content,
                         NOW(),
                         :post_id,
                         :comment_flag,
                         :comment_new)';
        $this->createQuery($request, [
            'comment_author'=>$post->get('author'),
            'comment_content'=>$post->get('content'),
            'post_id'=>$postId,
            'comment_flag'=>0,
            'comment_new'=>$commentIsNew
        ]);
    }

	public function updateOneComment($commentId, Parameter $post)
	{
	    $request = 'UPDATE 
                        comment 
                    SET 
                        comment_author = :comment_author, 
                        comment_content = :comment_content, 
                        comment_date = NOW() 
                    WHERE id = :id';
		$this->createQuery($request, [
            'comment_author'=>$post->get('author'),
		    'comment_content'=>$post->get('content'),
            'id'=>$commentId
        ]);
	}

	public function deleteOneComment($commentId)
	{
	    $request = 'DELETE FROM comment WHERE id = :commentId';
        $this->createQuery($request, [
            'commentId'=>$commentId
        ]);
	}

    public function deleteAllCommentsOfOnePost($postId)
    {
        $request = 'DELETE FROM comment WHERE comment_post_id = :postId';
        $this->createQuery($request, [
            'postId'=>$postId
        ]);
    }

    public function getNewComments()
    {
        $request = 'SELECT 
                        id, 
                        comment_author, 
                        comment_content, 
                        DATE_FORMAT(comment_date, \'%d/%m/%Y à %Hh%i\') AS comment_date_fr, 
                        comment_post_id,
                        comment_new
                    FROM 
                        comment 
                    WHERE 
                        comment_new = :commentNew 
                    ORDER BY 
                         comment_date DESC';
        $result = $this->createQuery($request, [
            'commentNew'=>1
        ]);
        $comments = [];
        foreach ($result as $row) {
            $commentId = $row['id'];
            $comments[$commentId] = $this->buildObject($row);
        }
        $result->closeCursor();
        return $comments;
    }

    public function validateOneComment($commentId)
    {
        $request = 'UPDATE 
                        comment 
                    SET 
                        comment_new = :comment_new
                    WHERE id = :id';
        $this->createQuery($request, [
            'comment_new'=>0,
            'id'=>$commentId
        ]);
    }

    public function getFlagComments()
    {
        $request = 'SELECT 
                        id, 
                        comment_author, 
                        comment_content, 
                        DATE_FORMAT(comment_date, \'%d/%m/%Y à %Hh%i\') AS comment_date_fr, 
                        comment_post_id,
                        comment_flag
                    FROM 
                        comment 
                    WHERE 
                        comment_flag = :commentFlag 
                    ORDER BY 
                         comment_date DESC';
        $result = $this->createQuery($request, [
            'commentFlag'=>1
        ]);
        $comments = [];
        foreach ($result as $row) {
            $commentId = $row['id'];
            $comments[$commentId] = $this->buildObject($row);
        }
        $result->closeCursor();
        return $comments;
    }

    public function flagOneComment($commentId)
    {
        $request = 'UPDATE 
                        comment 
                    SET 
                        comment_flag = :comment_flag
                    WHERE id = :id';
        $this->createQuery($request, [
            'comment_flag'=>1,
            'id'=>$commentId
        ]);
    }

    public function unflagOneComment($commentId)
    {
        $request = 'UPDATE 
                        comment 
                    SET 
                        comment_flag = :comment_flag
                    WHERE id = :id';
        $this->createQuery($request, [
            'comment_flag'=>0,
            'id'=>$commentId
        ]);
    }

}
