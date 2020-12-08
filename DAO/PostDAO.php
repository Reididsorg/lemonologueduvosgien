<?php

namespace BrunoGrosdidier\Blog\DAO;

use BrunoGrosdidier\Blog\config\Parameter;
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
        if(isset($row['post_author']))
        {
            $post->setPostAuthor($row['post_author']);
        }
        if(isset($row['post_date_fr']))
        {
            $post->setPostDateFr($row['post_date_fr']);
        }
        return $post;
    }

	public function selectOnePost($postId)
	{
		/*$request = 'SELECT id, post_title, post_content, DATE_FORMAT(post_date, \'%d/%m/%Y à %Hh%imin%ss\') AS post_date_fr FROM post WHERE id = ?';
        $result = $this->createQuery($request, [$postId]);*/
        $request = 'SELECT 
                        id, 
                        post_title, 
                        post_content,
                        post_author,
                        DATE_FORMAT(post_date, \'%d/%m/%Y à %Hh%imin%ss\') AS post_date_fr
                    FROM
                        post 
                    WHERE 
                        id = :id';
        $result = $this->createQuery($request, [
            'id'=>$postId
        ]);
        $post = $result->fetch();
        $result->closeCursor();
        return $this->buildObject($post);
	}

	public function selectAllPosts()
	{
        $request = 'SELECT 
                        id, 
                        post_title, 
                        post_content, 
                        post_author,
                        DATE_FORMAT(post_date, \'%d/%m/%Y à %Hh%imin%ss\') AS post_date_fr
                    FROM 
                        post 
                    ORDER BY 
                        post_date DESC 
                    LIMIT 0, 15';
        $result = $this->createQuery($request);
        $posts = [];
        foreach($result as $row){
            $postId = $row['id'];
            $posts[$postId] = $this->buildObject($row);
        }
        $result->closeCursor();
        return $posts;
	}

    public function insertOnePost(Parameter $post)
    {
        /*$request = 'INSERT INTO post (post_title, post_content, post_date) VALUES(?, ?, NOW())';
        $this->createQuery($request, [$post->get('postTitle'), $post->get('postContent')]);*/
        $request = 'INSERT INTO post 
                        (post_title, 
                         post_content, 
                         post_date,
                         post_author) 
                    VALUES
                        (:post_title, 
                         :post_content, 
                         NOW(),
                         :post_author)';
        $this->createQuery($request, [
            'post_title'=>$post->get('title'),
            'post_content'=>$post->get('content'),
            'post_author'=>$post->get('author')
        ]);
    }

    public function updateOnePost($postId, Parameter $post)
    {
        /*$request = 'UPDATE post SET post_title = ?, post_content = ?, post_date = NOW() WHERE id = ?';
        $this->createQuery($request, [$post->get('title'), $post->get('content'), $postId]);*/
        $request = 'UPDATE 
                        post 
                    SET 
                        post_title = :post_title, 
                        post_content = :post_content, 
                        post_date = NOW(),
                        post_author = :post_author
                    WHERE 
                        id = :id';
        $this->createQuery($request, [
            'post_title'=>$post->get('title'),
            'post_content'=>$post->get('content'),
            'post_author'=>$post->get('author'),
            'id'=>$postId
        ]);
    }

	public function deleteOnePost($postId)
	{
		/*$request = 'DELETE FROM post WHERE id = ?';
        $this->createQuery($request, [$postId]);*/
        $request = 'DELETE FROM post WHERE id = :id';
        $this->createQuery($request, [
            'id'=>$postId
        ]);
	}
}
