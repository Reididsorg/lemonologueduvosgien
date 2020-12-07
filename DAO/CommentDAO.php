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
        if(isset($row['post_id']))
        {
            $comment->setPostId($row['post_id']);
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
                        post_id 
                    FROM 
                        comment 
                    WHERE 
                        post_id = :post_id 
                    ORDER BY comment_date DESC';
        $result = $this->createQuery($request, [
            'post_id'=>$postId
        ]);
        $comments = [];
        foreach($result as $row){
            $commentId = $row['id'];
            $comments[$commentId] = $this->buildObject($row);
        }
        $result->closeCursor();
        return $comments;
	}

	public function selectOneComment($id)
	{
		/*$request = 'SELECT id, comment_author, comment_content, DATE_FORMAT(comment_date, \'%d/%m/%Y à %Hh%imin%ss\') AS comment_date_fr FROM comment WHERE id = ?';
        $result = $this->createQuery($request, [$id]);*/
        $request = 'SELECT 
                        id, 
                        comment_author, 
                        comment_content, 
                        DATE_FORMAT(comment_date, \'%d/%m/%Y à %Hh%imin%ss\') AS comment_date_fr 
                    FROM 
                        comment 
                    WHERE 
                        id = :id';
        $result = $this->createQuery($request, [
            'id'=>$id
        ]);
        $comment = $result->fetch();
        $result->closeCursor();
        return $this->buildObject($comment);
	}

    public function insertOneComment($postId, Parameter $post)
    {
        /*$request = 'INSERT INTO comment (post_id, comment_author, comment_content, comment_date) VALUES(?, ?, ?, NOW())';
        $this->createQuery($request, [$postId, $post->get('author'), $post->get('comment')]);*/
        $request = 'INSERT INTO comment 
                        (post_id, 
                         comment_author, 
                         comment_content, 
                         comment_date)
                    VALUES
                        (:post_id,
                         :comment_author,
                         :comment_content,
                         NOW())';
        $this->createQuery($request, [
            'post_id'=>$postId,
            'comment_author'=>$post->get('author'),
            'comment_content'=>$post->get('comment')
        ]);
    }

	public function updateOneComment($id, Parameter $post)
	{
        /*$request = 'UPDATE comment SET comment_content = ?, comment_date = NOW() WHERE id = ?';
        $this->createQuery($request, [$post->get('commentText'), $id]);*/
	    $request = 'UPDATE 
                        comment 
                    SET 
                        comment_content = :comment_content, 
                        comment_date = NOW() 
                    WHERE id = :id';
		$this->createQuery($request, [
		    'comment_content'=>$post->get('commentText'),
            'id'=>$id
        ]);
	}

	public function deleteOneComment($id)
	{
        /*$request = 'DELETE FROM comment WHERE id = ?';
        $this->createQuery($request, [$id]);*/
	    $request = 'DELETE FROM comment WHERE id = :id';
        $this->createQuery($request, [
            'id'=>$id
        ]);
	}

    public function deleteAllCommentsOfOnePost($postId)
    {
        /*$request = 'DELETE FROM comment WHERE post_id = ?';
        $this->createQuery($request, [$postId]);*/
        $request = 'DELETE FROM comment WHERE post_id = :id';
        $this->createQuery($request, [
            'id'=>$postId
        ]);
    }
}
