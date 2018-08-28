<?php
/**
 * Created by PhpStorm.
 * User: codename-tkc
 * Date: 30/12/2017
 * Time: 17:56
 */

class RatingManager
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

    public function addRating($rating_user_id, $rating_location_id, $rating_value)
    {
        $sql = "INSERT INTO `ratings`(`rating_user_id`, `rating_location_id`, `rating_value`) VALUES (?,?,?)";
        $query = $this->pdo->prepare($sql);
        return $query->execute(array($rating_user_id, $rating_location_id, $rating_value));
    }

    public function updateRating($rating_id, $rating_user_id, $rating_location_id, $rating_value)
    {
        if ($rating_id != null) {
            if ($rating_user_id != null) {
                $query = $this->pdo->prepare("UPDATE `ratings` SET `rating_user_id` = ? WHERE `rating_id` = ?");
                $query->execute(array($rating_user_id, $rating_id));
            }
            if ($rating_location_id != null) {
                $query = $this->pdo->prepare("UPDATE `ratings` SET `rating_location_id` = ? WHERE `rating_id` = ?");
                $query->execute(array($rating_location_id, $rating_id));
            }
            if ($rating_value != null) {
                $query = $this->pdo->prepare("UPDATE `ratings` SET `rating_value` = ? WHERE `rating_id` = ?");
                $query->execute(array($rating_value, $rating_id));
            }
        }
    }

    public function getRating()
    {
        $query = $this->pdo->prepare("SELECT * FROM `ratings`");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getSiteRating($site_id)
    {
        $query = $this->pdo->prepare("SELECT * FROM `ratings` WHERE `rating_location_id` = {$site_id} ");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function checkUserRated($site_id, $user_id)
    {
        $query = $this->pdo->prepare("SELECT * FROM `ratings` WHERE `rating_location_id` = {$site_id} AND `rating_user_id` = {$user_id}");
        $query->execute();
        $r = $query->fetchAll(PDO::FETCH_ASSOC);
        if (empty($r)) {
            return true;
        } else {
            return false;
        }
    }

    public function deregisterRating($rating_id)
    {
        $query = $this->pdo->prepare("DELETE FROM `ratings` WHERE `rating_id` = ?");
        return $query->execute(array($rating_id));
    }

    public function getRatingById($rating_id)
    {
        $query = $this->pdo->prepare("SELECT * FROM `ratings` WHERE `rating_id` = ?");
        $query->execute(array($rating_id));
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
}