<?php
/**
 * Created by PhpStorm.
 * User: codename-tkc
 * Date: 30/12/2017
 * Time: 18:11
 */

class SubscriptionManager
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
    public function subscribe($user_id,$site_id){
        $sql ="INSERT INTO `subscriptions`(`subscription_user_id`, `subscription_location_id`) VALUES (?,?)";
        $query = $this->pdo->prepare($sql);
        return $query->execute(array($user_id,$site_id));
    }
    public function unsubscribe($user_id,$site_id){
        $sql ="DELETE FROM `subscriptions` WHERE `subscription_location_id` = {$site_id} AND `subscription_user_id` = {$user_id}";
        $query = $this->pdo->prepare($sql);
        return $query->execute();
    }
}