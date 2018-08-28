<?php
/**
 * Created by PhpStorm.
 * User: codename-tkc
 * Date: 30/12/2017
 * Time: 18:18
 */

class VisitManager
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

    public function visit($user_id, $site_id)
    {
        $sql = "INSERT INTO `visits`(`visit_user_id`, `visit_location_id`) VALUES (?,?)";
        $query = $this->pdo->prepare($sql);
        return $query->execute(array($user_id, $site_id));
    }
}