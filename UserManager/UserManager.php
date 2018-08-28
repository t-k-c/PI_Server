<?php
/**
 * Created by PhpStorm.
 * User: codename-tkc
 * Date: 29/12/2017
 * Time: 16:18
 */

class UserManager
{
    public $pdo;
    public function __construct()
    {
        try {
            $config = json_decode(file_get_contents('../config/config.json'), true);
            $this->pdo = new PDO("mysql:host=" . $config['host'] . ";dbname=" . $config['database_name'], $config['user_name'], $config['password']);
        }catch (PDOException $e){
            die($e->getMessage());
        }
    }
    public function addUser($user_name,$user_category,$user_password){
        $query = $this->pdo->prepare("INSERT INTO `users`(`user_name`, `user_password`, `user_category`, `user_created_at`) VALUES (?,?,?,NOW())");
        return $query->execute(array($user_name,$user_password,$user_category));
    }
    public function deleteUser($user_id){
        $query = $this->pdo->prepare("DELETE FROM `users` WHERE `user_id` = ?");
        return $query->execute(array($user_id));
    }
    public function modifyUser($user_id,$user_name,$user_category,$user_password){
        if($user_id!=null){
        if($user_name != null){
            $query = $this->pdo->prepare("UPDATE `users` SET `user_name` = ? WHERE `user_id` = ?");
            $query->execute(array($user_name,$user_id));
        }
        if($user_password != null){
            $query = $this->pdo->prepare("UPDATE `users` SET `user_password` = ? WHERE `user_id` = ?");
            $query->execute(array($user_password,$user_id));
        }
        if($user_category != null){
            $query = $this->pdo->prepare("UPDATE `users` SET `user_category` = ? WHERE `user_id` = ?");
            $query->execute(array($user_category,$user_id));
        }
    }
    }
    public function getUserDetails($user_id){
        $query = $this->pdo->prepare("SELECT * FROM `users` WHERE `user_id` = ?");
        $query->execute(array($user_id));
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
}
$u = new UserManager();
