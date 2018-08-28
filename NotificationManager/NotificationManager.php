<?php
/**
 * Created by PhpStorm.
 * User: codename-tkc
 * Date: 30/12/2017
 * Time: 17:44
 */

class NotificationManager
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
    public function addNotification($notification_source_id, $notification_destination_id, $notification_content_en, $notification_content_fr, $notification_time)
    {
        $sql = "INSERT INTO `notifications`(`notification_source_id`, `notification_destination_id`, `notification_content_en`, `notification_content_fr`, `notification_time`) VALUES (?,?,?,?,?)";        $query = $this->pdo->prepare($sql);
        return $query->execute(array($notification_source_id, $notification_destination_id, $notification_content_en, $notification_content_fr, $notification_time));
    }
    public function updateNotification($notification_id, $notification_source_id, $notification_destination_id, $notification_content_en, $notification_content_fr, $notification_time){
        if($notification_id != null){
            if($notification_source_id != null){
                $query = $this->pdo->prepare("UPDATE `notifications` SET `notification_source_id` = ? WHERE `notification_id` = ?");
                $query->execute(array($notification_source_id,$notification_id));
            }
            if($notification_destination_id != null){
                $query = $this->pdo->prepare("UPDATE `notifications` SET `notification_destination_id` = ? WHERE `notification_id` = ?");
                $query->execute(array($notification_destination_id,$notification_id));
            }
            if($notification_content_en != null){
                $query = $this->pdo->prepare("UPDATE `notifications` SET `notification_content_en` = ? WHERE `notification_id` = ?");
                $query->execute(array($notification_content_en,$notification_id));
            }
            if($notification_content_fr != null){
                $query = $this->pdo->prepare("UPDATE `notifications` SET `notification_content_fr` = ? WHERE `notification_id` = ?");
                $query->execute(array($notification_content_fr,$notification_id));
            }
            if($notification_time != null){
                $query = $this->pdo->prepare("UPDATE `notifications` SET `notification_time` = ? WHERE `notification_id` = ?");
                $query->execute(array($notification_time,$notification_id));
            }
        }
    }
    public function getNotification()
    {
        $query = $this->pdo->prepare("SELECT * FROM `notifications`");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deregisterNotification($notification_id){
        $query = $this->pdo->prepare("DELETE FROM `notifications` WHERE `notification_id` = ?");
        return $query->execute(array($notification_id));
    }

    public function getNotificationById($notification_id){
        $query = $this->pdo->prepare("SELECT * FROM `notifications` WHERE `notification_id` = ?");
        $query->execute(array($notification_id));
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getNotificationByDestinationId($destination_id){
        $query = $this->pdo->prepare("SELECT * FROM `notifications` WHERE `notification_destination_id` = ?");
        $query->execute(array($destination_id));
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
}