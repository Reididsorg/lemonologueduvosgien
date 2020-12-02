<?php

namespace BrunoGrosdidier\Blog\DAO;

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
		$request = 'SELECT id, comment_author, comment_content, DATE_FORMAT(comment_date, \'%d/%m/%Y à %Hh%imin%ss\') AS comment_date_fr, post_id FROM comment WHERE post_id = ? ORDER BY comment_date DESC';
        $result = $this->createQuery($request, [$postId]);
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
		$request = 'SELECT id, comment_author, comment_content, DATE_FORMAT(comment_date, \'%d/%m/%Y à %Hh%imin%ss\') AS comment_date_fr FROM comment WHERE id = ?';
        $result = $this->createQuery($request, [$id]);
        $comment = $result->fetch();
        $result->closeCursor();
        return $this->buildObject($comment);
	}

    public function insertOneComment($postId, $commentAuthor, $commentContent)
    {
        $request = 'INSERT INTO comment (post_id, comment_author, comment_content, comment_date) VALUES(?, ?, ?, NOW())';
        $this->createQuery($request, [$postId, $commentAuthor, $commentContent]);
    }

	public function updateOneComment($id, $commentContent)
	{
	    $request = 'UPDATE comment SET comment_content = ?, comment_date = NOW() WHERE id = ?';
		$this->createQuery($request, [$commentContent, $id]);
	}

	public function deleteOneComment($id)
	{
		$request = 'DELETE FROM comment WHERE id = ?';
        $this->createQuery($request, [$id]);
	}

    public function deleteAllCommentsOfOnePost($postId)
    {
        var_dump($postId);
        $request = 'DELETE FROM comment WHERE post_id = ?';
        $this->createQuery($request, [$postId]);
    }
}
