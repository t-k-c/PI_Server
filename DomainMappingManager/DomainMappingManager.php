<?php
/**
 * Created by PhpStorm.
 * User: codename-tkc
 * Date: 30/12/2017
 * Time: 17:34
 */

class DomainMappingManager
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
    public function map($site_id,$domain_id){
        $sql ="INSERT INTO `domain_mappings`(`location_id`, `domain_id`) VALUES (?,?)";
        $query = $this->pdo->prepare($sql);
        $query->execute(array($site_id,$domain_id));
    }
}