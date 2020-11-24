<?php

namespace BrunoGrosdidier\Blog\DAO;

require_once("DAO/DAO.php");

class CommentDAO extends DAO
{
	public function insertOneComment($postId, $author, $comment)
	{
		$request = 'INSERT INTO comment (post_id, comment_author, comment_content, comment_date) VALUES(?, ?, ?, NOW())';
		return $this->createQuery($request, [$postId, $author, $comment]);
	}

	public function selectAllCommentsOfOnePost($postId)
	{
		$request = 'SELECT id, comment_author, comment_content, DATE_FORMAT(comment_date, \'%d/%m/%Y à %Hh%imin%ss\') AS comment_date_fr FROM comment WHERE post_id = ? ORDER BY comment_date DESC';
		return $this->createQuery($request, [$postId]);		
	}

	public function selectOneComment($commentId)
	{
		$request = 'SELECT id, comment_author, comment_content, DATE_FORMAT(comment_date, \'%d/%m/%Y à %Hh%imin%ss\') AS comment_date_fr FROM comment WHERE id = ?';
		return $this->createQuery($request, [$commentId]);
	}

	public function updateOneComment($commentId, $commentText)
	{
		$request = 'UPDATE comment SET comment_content = ?, comment_date = NOW() WHERE id = ?';
		return $this->createQuery($request, [$commentText, $commentId]);
	}

	public function deleteOneComment($commentId)
	{
		$request = 'DELETE FROM comment WHERE id = ?';
		return $this->createQuery($request, [$commentId]);
	}
}
