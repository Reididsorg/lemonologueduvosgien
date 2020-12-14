<?php

namespace BrunoGrosdidier\Blog\DAO;

use BrunoGrosdidier\Blog\config\Parameter;
use BrunoGrosdidier\Blog\src\model\Comment;

class CommentDAO extends DAO
{
    private function buildObject($row)
    {
        $comment = new Comment();
        if(isset($row['id']))
        {
            $comment->setId($row['id']);
        }
        if(isset($row['comment_author']))
        {
            $comment->setCommentAuthor($row['comment_author']);
        }
        if(isset($row['comment_content']))
        {
            $comment->setCommentContent($row['comment_content']);
        }
        if(isset($row['comment_date_fr']))
        {
            $comment->setCommentDateFr($row['comment_date_fr']);
        }
        if(isset($row['comment_post_id']))
        {
            $comment->setCommentPostId($row['comment_post_id']);
        }
        if(isset($row['comment_flag']))
        {
            $comment->setCommentFlag($row['comment_flag']);
        }
        return $comment;
    }

	public function selectAllCommentsOfOnePost($postId)
	{
		/*$request = 'SELECT id, comment_author, comment_content, DATE_FORMAT(comment_date, \'%d/%m/%Y à %Hh%imin%ss\') AS comment_date_fr, post_id FROM comment WHERE post_id = ? ORDER BY comment_date DESC';
        $result = $this->createQuery($request, [$postId]);*/
        $request = 'SELECT 
                        id, 
                        comment_author, 
                        comment_content, 
                        DATE_FORMAT(comment_date, \'%d/%m/%Y à %Hh%imin%ss\') AS comment_date_fr, 
                        comment_post_id,
                        comment_flag
                    FROM 
                        comment 
                    WHERE 
                        comment_post_id = :postId 
                    ORDER BY comment_date DESC';
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
		/*$request = 'SELECT id, comment_author, comment_content, DATE_FORMAT(comment_date, \'%d/%m/%Y à %Hh%imin%ss\') AS comment_date_fr, comment_post_id FROM comment WHERE id = ?';
        $result = $this->createQuery($request, [$id]);*/
        $request = 'SELECT 
                        id, 
                        comment_author, 
                        comment_content, 
                        DATE_FORMAT(comment_date, \'%d/%m/%Y à %Hh%imin%ss\') AS comment_date_fr,
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
        /*$request = 'INSERT INTO comment (comment_post_id, comment_author, comment_content, comment_date) VALUES(?, ?, ?, NOW())';
        $this->createQuery($request, [$postId, $post->get('author'), $post->get('comment')]);*/
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
        /*$request = 'UPDATE comment SET comment_content = ?, comment_date = NOW() WHERE id = ?';
        $this->createQuery($request, [$post->get('commentText'), $id]);*/
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
        /*$request = 'DELETE FROM comment WHERE id = ?';
        $this->createQuery($request, [$id]);*/
	    $request = 'DELETE FROM comment WHERE id = :commentId';
        $this->createQuery($request, [
            'commentId'=>$commentId
        ]);
	}

    public function deleteAllCommentsOfOnePost($postId)
    {
        /*$request = 'DELETE FROM comment WHERE comment_post_id = ?';
        $this->createQuery($request, [$postId]);*/
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
}
