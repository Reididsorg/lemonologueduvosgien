<?php

namespace BrunoGrosdidier\Blog\src\DAO;

use BrunoGrosdidier\Blog\config\Parameter;
use BrunoGrosdidier\Blog\src\Model\Comment;

class CommentDAO extends DAO
{
    private function buildObject($row)
    {
        $comment = new Comment();
        $comment->setId($row['id']);
        $comment->setCommentAuthor($row['comment_author']);
        $comment->setCommentContent($row['comment_content']);
        $comment->setCommentDateFr($row['comment_date_fr']);
        $comment->setCommentPostId($row['comment_post_id']);
        $comment->setCommentFlag($row['comment_flag']);
        return $comment;
    }

    public function countAllComments($postId)
    {
        $request = 'SELECT 
                        COUNT(*) 
                    FROM 
                        comment 
                    WHERE 
                        comment_post_id = :postId';
        return $this->createQuery($request, [
            'postId'=>$postId
        ])->fetchColumn();
    }

	public function selectAllCommentsOfOnePost($postId, $limit = null, $start = null)
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
                        comment_post_id = :postId 
                    ORDER BY comment_date DESC';
        $sql = 'SELECT id, pseudo, content, createdAt, flag FROM comment WHERE article_id = ? ORDER BY createdAt DESC';
        if($limit) {
            $request .= ' LIMIT '.$limit.' OFFSET '.$start;
        }
        $result = $this->createQuery($request, [
            'postId'=>$postId
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

    public function insertOneComment($postId, Parameter $post)
    {
        $request = 'INSERT INTO comment 
                        (comment_author, 
                         comment_content, 
                         comment_date,
                         comment_post_id,
                         comment_flag)
                    VALUES
                        (:comment_author,
                         :comment_content,
                         NOW(),
                         :post_id,
                         :comment_flag)';
        $this->createQuery($request, [
            'comment_author'=>$post->get('author'),
            'comment_content'=>$post->get('content'),
            'post_id'=>$postId,
            'comment_flag'=>0,
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
}
