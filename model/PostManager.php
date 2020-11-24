<?php

namespace BrunoGrosdidier\Blog\Model;

require_once("model/Manager.php");

class PostManager extends Manager
{
	public function insertOnePost($title, $content)
	{
		$request = 'INSERT INTO post (post_title, post_content, post_date) VALUES(?, ?, NOW())';
		return $this->createQuery($request, [$title, $content]);
	}

	public function selectOnePost($postId)
	{
		$request = 'SELECT id, post_title, post_content, DATE_FORMAT(post_date, \'%d/%m/%Y à %Hh%imin%ss\') AS creation_date_fr FROM post WHERE id = ?';
		return $this->createQuery($request, [$postId]);		
	}

	public function selectAllPosts()
	{
		$request = 'SELECT id, post_title, post_content, DATE_FORMAT(post_date, \'%d/%m/%Y à %Hh%imin%ss\') AS creation_date_fr FROM post ORDER BY post_date DESC LIMIT 0, 5';
		return $this->createQuery($request);
	}

	public function updateOnePost($postId, $title, $content)
	{
		$request = 'UPDATE post SET post_title = ? post_content = ?, post_date = NOW() WHERE id = ?';
		return $this->createQuery($request, [$title, $content, $postId]);
	}

	public function deleteOnePost($postId)
	{
		$request = 'DELETE FROM post WHERE id = ?';
		return $this->createQuery($request, [$postId]);
	}
}
