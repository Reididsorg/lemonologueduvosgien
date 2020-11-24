<?php

namespace BrunoGrosdidier\Blog\Model;

require_once("model/Manager.php");

class PostManager extends Manager
{
	public function insertOnePost($title, $content)
	{
		$dbConnection = $this->dbConnect();
		$request = $dbConnection->prepare('INSERT INTO post (post_title, post_content, post_date) VALUES(?, ?, NOW())');
		$affectedLine = $request->execute(array($postId, $author, $comment));

		return $affectedLine;
	}

	public function selectOnePost($postId)
	{
		$dbConnection = $this->dbConnect();
		$request = $dbConnection->prepare('SELECT id, post_title, post_content, DATE_FORMAT(post_date, \'%d/%m/%Y à %Hh%imin%ss\') AS creation_date_fr FROM post WHERE id = ?');
		$request->execute(array($postId));
		$affectedLine = $request->fetch();

		return $affectedLine;		
	}

	public function selectAllPosts()
	{
/*		
		$dbConnection = $this->dbConnect();
		$request = $dbConnection->prepare('SELECT id, post_title, post_content, DATE_FORMAT(post_date, \'%d/%m/%Y à %Hh%imin%ss\') AS creation_date_fr FROM post ORDER BY post_date DESC LIMIT 0, 5');	
		$request->execute(array());
		$affectedLines = $request->fetch();

		return $affectedLines;	
*/
		$dbConnection = $this->dbConnect();
		$request = 'SELECT id, post_title, post_content, DATE_FORMAT(post_date, \'%d/%m/%Y à %Hh%imin%ss\') AS creation_date_fr FROM post ORDER BY post_date DESC LIMIT 0, 5';	
		$affectedLines = $dbConnection->query($request);

		return $affectedLines;
	}

	public function updateOnePost($postId, $title, $content)
	{
		$dbConnection = $this->dbConnect();
		$request = $dbConnection->prepare('UPDATE post SET post_title = ? post_content = ?, post_date = NOW() WHERE id = ?');
		$affectedLine = $request->execute(array($title, $content, $postId));

		return $affectedLine;
	}

	public function deleteOnePost($postId)
	{
		$dbConnection = $this->dbConnect();
		$request = $dbConnection->prepare('DELETE FROM post WHERE id = ?');
		$affectedLine = $request->execute(array($postId));

		return $affectedLine;
	}
}
