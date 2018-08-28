<?php
/**
 * Created by PhpStorm.
 * User: codename-tkc
 * Date: 30/12/2017
 * Time: 18:16
 */

class BroadCastManager
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
    public function addBroadcast($broadcast_content_en, $broadcast_content_fr, $broadcast_distance)
    {
        $sql = "INSERT INTO `broadcasts`(`broadcast_content_en`, `broadcast_content_fr`, `broadcast_distance`) VALUES (?,?,?)";        $query = $this->pdo->prepare($sql);
        return $query->execute(array($broadcast_content_en, $broadcast_content_fr, $broadcast_distance));
    }
    public function updateBroadcast($broadcast_id, $broadcast_content_en, $broadcast_content_fr, $broadcast_distance){
        if($broadcast_id != null){
            if($broadcast_content_en != null){
                $query = $this->pdo->prepare("UPDATE `broadcasts` SET `broadcast_content_en` = ? WHERE `broadcast_id` = ?");
                $query->execute(array($broadcast_content_en,$broadcast_id));
            }
            if($broadcast_content_fr != null){
                $query = $this->pdo->prepare("UPDATE `broadcasts` SET `broadcast_content_fr` = ? WHERE `broadcast_id` = ?");
                $query->execute(array($broadcast_content_fr,$broadcast_id));
            }
            if($broadcast_distance != null){
                $query = $this->pdo->prepare("UPDATE `broadcasts` SET `broadcast_distance` = ? WHERE `broadcast_id` = ?");
                $query->execute(array($broadcast_distance,$broadcast_id));
            }
        }
    }
    public function getBroadcast()
    {
        $query = $this->pdo->prepare("SELECT * FROM `broadcasts`");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deregisterBroadcast($broadcast_id){
        $query = $this->pdo->prepare("DELETE FROM `broadcasts` WHERE `broadcast_id` = ?");
        return $query->execute(array($broadcast_id));
    }

    public function getBroadcastById($broadcast_id){
        $query = $this->pdo->prepare("SELECT * FROM `broadcasts` WHERE `broadcast_id` = ?");
        $query->execute(array($broadcast_id));
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
}