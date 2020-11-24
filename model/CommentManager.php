<?php

namespace BrunoGrosdidier\Blog\Model;

require_once("model/Manager.php");

class CommentManager extends Manager
{
	
	// constructeur
	// factoriser instanciation $dbConnection

	public function insertOneComment($postId, $author, $comment)
	{
		$dbConnection = $this->dbConnect();
		$request = $dbConnection->prepare('INSERT INTO comment (post_id, comment_author, comment_content, comment_date) VALUES(?, ?, ?, NOW())');
		$affectedLine = $request->execute(array($postId, $author, $comment));

		return $affectedLine;
	}

	public function selectAllCommentsOfOnePost($postId)
	{
		$dbConnection = $this->dbConnect();
		$request = 'SELECT id, comment_author, comment_content, DATE_FORMAT(comment_date, \'%d/%m/%Y à %Hh%imin%ss\') AS comment_date_fr FROM comment WHERE post_id = ? ORDER BY comment_date DESC';
		$affectedLines = $dbConnection->prepare($request);	
		$affectedLines->execute(array($postId));

		return $affectedLines;		
	}

	public function selectOneComment($commentId)
	{
		$dbConnection = $this->dbConnect();
		$request = $dbConnection->prepare('SELECT id, comment_author, comment_content, DATE_FORMAT(comment_date, \'%d/%m/%Y à %Hh%imin%ss\') AS comment_date_fr FROM comment WHERE id = ?');
		$request->execute(array($commentId));
		$affectedLine = $request->fetch();

		return $affectedLine;
	}

	public function updateOneComment($commentId, $commentText)
	{
		$dbConnection = $this->dbConnect();
		$request = $dbConnection->prepare('UPDATE comment SET comment_content = ?, comment_date = NOW() WHERE id = ?');
		$affectedLine = $request->execute(array($commentText, $commentId));

		return $affectedLine;
	}

	public function deleteOneComment($commentId)
	{
		$dbConnection = $this->dbConnect();
		$request = $dbConnection->prepare('DELETE FROM comment WHERE id = ?');
		$affectedLine = $request->execute(array($commentId));

		return $affectedLine;
	}
}
