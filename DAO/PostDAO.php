<?php

namespace BrunoGrosdidier\Blog\DAO;

use BrunoGrosdidier\Blog\src\model\Post;

class PostDAO extends DAO
{
    private function buildObject($row)
    {
        $post = new Post();
        if(isset($row['id']))
        {
            $post->setId($row['id']);
        }
        if(isset($row['post_title']))
        {
            $post->setPostTitle($row['post_title']);
        }
        if(isset($row['post_content']))
        {
            $post->setPostContent($row['post_content']);
        }
        if(isset($row['author']))
        {
            $post->setPostAuthor($row['author']);
        }
        if(isset($row['post_date_fr']))
        {
            $post->setPostDateFr($row['post_date_fr']);
        }
        return $post;
    }

    public function insertOnePost($postTitle, $postContent)
	{
		$request = 'INSERT INTO post (post_title, post_content, post_date) VALUES(?, ?, NOW())';
        $result = $this->createQuery($request, [$postTitle, $postContent]);
        $response = $result->fetch();
        $result->closeCursor();
        return $this->buildObject($response);
	}

	public function selectOnePost($postId)
	{
		$request = 'SELECT id, post_title, post_content, DATE_FORMAT(post_date, \'%d/%m/%Y à %Hh%imin%ss\') AS post_date_fr FROM post WHERE id = ?';
        $result = $this->createQuery($request, [$postId]);
        $post = $result->fetch();
        $result->closeCursor();
        return $this->buildObject($post);
        //return $this->createQuery($request, [$postId]);
	}

	public function selectAllPosts()
	{
		$request = 'SELECT id, post_title, post_content, DATE_FORMAT(post_date, \'%d/%m/%Y à %Hh%imin%ss\') AS post_date_fr FROM post ORDER BY post_date DESC LIMIT 0, 5';
        $result = $this->createQuery($request);
        $posts = [];
        foreach($result as $row){
            $postId = $row['id'];
            $posts[$postId] = $this->buildObject($row);
        }
        $result->closeCursor();
        return $posts;
	}

	public function updateOnePost($postId, $postTitle, $postContent)
	{
		$request = 'UPDATE post SET post_title = ? post_content = ?, post_date = NOW() WHERE id = ?';
        $result = $this->createQuery($request, [$postId, $postTitle, $postContent]);
        $response = $result->fetch();
        $result->closeCursor();
        return $this->buildObject($response);
	}

	public function deleteOnePost($postId)
	{
		$request = 'DELETE FROM post WHERE id = ?';
        $result = $this->createQuery($request, [$postId]);
        $response = $result->fetch();
        $result->closeCursor();
        return $this->buildObject($response);
	}
}

