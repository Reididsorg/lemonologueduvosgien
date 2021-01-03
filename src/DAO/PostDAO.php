<?php

namespace BrunoGrosdidier\Blog\src\DAO;

use BrunoGrosdidier\Blog\config\Parameter;
use BrunoGrosdidier\Blog\src\Model\Post;

class PostDAO extends DAO
{
    private function buildObject($row)
    {
        $post = new Post();
        $post->setId($row['id']);
        $post->setPostTitle($row['post_title']);
        $post->setPostContent($row['post_content']);
        $post->setPostAuthor($row['postAuthor']);
        $post->setPostDateFr($row['post_date_fr']);
        return $post;
    }

	public function selectOnePost($postId)
	{
        $request = 'SELECT 
                        post.id, 
                        post.post_title, 
                        post.post_content,
                        DATE_FORMAT(post.post_date, \'%d/%m/%Y à %Hh%i\') AS post_date_fr,
                        user.user_pseudo AS postAuthor
                    FROM
                        post
                    INNER JOIN user
                        ON user.id = post.user_id
                    WHERE 
                        post.id = :id';
        $result = $this->createQuery($request, [
            'id'=>$postId
        ]);
        $post = $result->fetch();
        $result->closeCursor();
        return $this->buildObject($post);
	}

    public function countAllPosts()
    {
        $request = 'SELECT 
                        COUNT(*) 
                    FROM 
                        post';
        return $this->createQuery($request)->fetchColumn();
    }

    public function selectAllPosts($limit = null, $start = null)
	{
        $request = 'SELECT 
                        post.id, 
                        post.post_title, 
                        post.post_content, 
                        DATE_FORMAT(post.post_date, \'%d/%m/%Y à %Hh%i\') AS post_date_fr,
                        user_pseudo AS postAuthor
                    FROM 
                        post
                    INNER JOIN user
                        ON user.id = post.user_id
                    ORDER BY 
                        post_date DESC';
        if($limit) {
            $request .= ' LIMIT '.$limit.' OFFSET '.$start;
        }
        $result = $this->createQuery($request);
        $posts = [];
        foreach($result as $row){
            $postId = $row['id'];
            $posts[$postId] = $this->buildObject($row);
        }
        $result->closeCursor();
        return $posts;
	}

    public function insertOnePost(Parameter $post, $userId)
    {
        $request = 'INSERT INTO post
                        (post_title, 
                         post_content, 
                         post_date,
                         user_id) 
                    VALUES
                        (:title, 
                         :content, 
                         NOW(),
                         :userId)';
        $this->createQuery($request, [
            'title'=>$post->get('title'),
            'content'=>$post->get('content'),
            'userId'=>$userId
        ]);
    }

    public function updateOnePost($postId, Parameter $post, $userId)
    {
        $request = 'UPDATE 
                        post 
                    SET 
                        post_title = :post_title, 
                        post_content = :post_content, 
                        post_date = NOW(),
                        user_id = :userId
                    WHERE 
                        id = :id';
        $this->createQuery($request, [
            'post_title'=>$post->get('title'),
            'post_content'=>$post->get('content'),
            'userId'=>$userId,
            'id'=>$postId
        ]);
    }

	public function deleteOnePost($postId)
	{
        $request = 'DELETE FROM post WHERE id = :id';
        $this->createQuery($request, [
            'id'=>$postId
        ]);
	}
}
