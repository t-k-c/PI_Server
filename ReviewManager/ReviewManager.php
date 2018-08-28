<?php
/**
 * Created by PhpStorm.
 * User: codename-tkc
 * Date: 30/12/2017
 * Time: 18:09
 */

class ReviewManager
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

    public function addReview($review_content, $review_location_id, $review_user_id)
    {
        $sql = "INSERT INTO `reviews`(`review_content`, `review_location_id`, `review_user_id`) VALUES (?,?,?)";
        $query = $this->pdo->prepare($sql);
        return $query->execute(array($review_content, $review_location_id, $review_user_id));
    }

    public function updateReview($review_id, $review_content, $review_location_id, $review_user_id)
    {
        if ($review_id != null) {
            if ($review_content != null) {
                $query = $this->pdo->prepare("UPDATE `reviews` SET `review_content` = ? WHERE `review_id` = ?");
                $query->execute(array($review_content, $review_id));
            }
            if ($review_location_id != null) {
                $query = $this->pdo->prepare("UPDATE `reviews` SET `review_location_id` = ? WHERE `review_id` = ?");
                $query->execute(array($review_location_id, $review_id));
            }
            if ($review_user_id != null) {
                $query = $this->pdo->prepare("UPDATE `reviews` SET `review_user_id` = ? WHERE `review_id` = ?");
                $query->execute(array($review_user_id, $review_id));
            }
        }
    }

    public function getReview()
    {
        $query = $this->pdo->prepare("SELECT * FROM `reviews`");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deregisterReview($review_id)
    {
        $query = $this->pdo->prepare("DELETE FROM `reviews` WHERE `review_id` = ?");
        return $query->execute(array($review_id));
    }

    public function getReviewById($review_id)
    {
        $query = $this->pdo->prepare("SELECT * FROM `reviews` WHERE `review_id` = ?");
        $query->execute(array($review_id));
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
}