<?php
/**
 * Created by PhpStorm.
 * User: codename-tkc
 * Date: 30/12/2017
 * Time: 17:54
 */

class PostManager
{
    public $pdo;

    public function __construct()
    {
        try {
            $config = json_decode(file_get_contents('../config/config.json'), true);
            $this->pdo = new PDO("mysql:host=" . $config['host'] . ";dbname=" . $config['database_name'], $config['user_name'], $config['password']);
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function addPost($post_location_id, $post_content, $post_featured_image)
    {
        $sql = "INSERT INTO `posts`(`post_location_id`, `post_content`, `post_featured_image`) VALUES (?,?,?)";
        $query = $this->pdo->prepare($sql);
        return $query->execute(array($post_location_id, $post_content, $post_featured_image));
    }

    public function updatePost($post_id, $post_location_id, $post_content, $post_featured_image)
    {
        if ($post_id != null) {
            if ($post_location_id != null) {
                $query = $this->pdo->prepare("UPDATE `posts` SET `post_location_id` = ? WHERE `post_id` = ?");
                $query->execute(array($post_location_id, $post_id));
            }
            if ($post_content != null) {
                $query = $this->pdo->prepare("UPDATE `posts` SET `post_content` = ? WHERE `post_id` = ?");
                $query->execute(array($post_content, $post_id));
            }
            if ($post_featured_image != null) {
                $query = $this->pdo->prepare("UPDATE `posts` SET `post_featured_image` = ? WHERE `post_id` = ?");
                $query->execute(array($post_featured_image, $post_id));
            }
        }
    }

    public function getPost()
    {
        $query = $this->pdo->prepare("SELECT * FROM `posts`");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deregisterPost($post_id)
    {
        $query = $this->pdo->prepare("DELETE FROM `posts` WHERE `post_id` = ?");
        return $query->execute(array($post_id));
    }

    public function getPostById($post_id)
    {
        $query = $this->pdo->prepare("SELECT * FROM `posts` WHERE `post_id` = ?");
        $query->execute(array($post_id));
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
}