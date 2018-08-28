<?php
/**
 * Created by PhpStorm.
 * User: codename-tkc
 * Date: 30/12/2017
 * Time: 16:10
 */

class DomainManager
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

    public function addDomain($domain_icon, $domain_name_fr, $domain_name_en, $producer_description_fr, $producer_description_en, $viewer_description_fr, $viewer_description_en, $domain_created_at)
    {
        $sql = "INSERT INTO `domains`(`domain_icon`, `domain_name_fr`, `domain_name_en`, `producer_description_fr`, `producer_description_en`, `viewer_description_fr`, `viewer_description_en`, `domain_created_at`) VALUES (?,?,?,?,?,?,?,?)";
        $query = $this->pdo->prepare($sql);
        return $query->execute(array($domain_icon, $domain_name_fr, $domain_name_en, $producer_description_fr, $producer_description_en, $viewer_description_fr, $viewer_description_en, $domain_created_at));
    }

    public function updateDomain($domain_id, $domain_icon, $domain_name_fr, $domain_name_en, $producer_description_fr, $producer_description_en, $viewer_description_fr, $viewer_description_en, $domain_created_at)
    {
        if ($domain_id != null) {
            if ($domain_icon != null) {
                $query = $this->pdo->prepare("UPDATE `domains` SET `domain_icon` = ? WHERE `domain_id` = ?");
                $query->execute(array($domain_icon, $domain_id));
            }
            if ($domain_name_fr != null) {
                $query = $this->pdo->prepare("UPDATE `domains` SET `domain_name_fr` = ? WHERE `domain_id` = ?");
                $query->execute(array($domain_name_fr, $domain_id));
            }
            if ($domain_name_en != null) {
                $query = $this->pdo->prepare("UPDATE `domains` SET `domain_name_en` = ? WHERE `domain_id` = ?");
                $query->execute(array($domain_name_en, $domain_id));
            }
            if ($producer_description_fr != null) {
                $query = $this->pdo->prepare("UPDATE `domains` SET `producer_description_fr` = ? WHERE `domain_id` = ?");
                $query->execute(array($producer_description_fr, $domain_id));
            }
            if ($producer_description_en != null) {
                $query = $this->pdo->prepare("UPDATE `domains` SET `producer_description_en` = ? WHERE `domain_id` = ?");
                $query->execute(array($producer_description_en, $domain_id));
            }
            if ($viewer_description_fr != null) {
                $query = $this->pdo->prepare("UPDATE `domains` SET `viewer_description_fr` = ? WHERE `domain_id` = ?");
                $query->execute(array($viewer_description_fr, $domain_id));
            }
            if ($viewer_description_en != null) {
                $query = $this->pdo->prepare("UPDATE `domains` SET `viewer_description_en` = ? WHERE `domain_id` = ?");
                $query->execute(array($viewer_description_en, $domain_id));
            }
            if ($domain_created_at != null) {
                $query = $this->pdo->prepare("UPDATE `domains` SET `domain_created_at` = ? WHERE `domain_id` = ?");
                $query->execute(array($domain_created_at, $domain_id));
            }
        }
    }

    public function getDomain()
    {
        $query = $this->pdo->prepare("SELECT * FROM `domains`");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deregisterDomain($domain_id)
    {
        $query = $this->pdo->prepare("DELETE FROM `domains` WHERE `domain_id` = ?");
        return $query->execute(array($domain_id));
    }

    public function getDomainById($domain_id)
    {
        $query = $this->pdo->prepare("SELECT * FROM `domains` WHERE `domain_id` = ?");
        $query->execute(array($domain_id));
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function searchDomain($domain_name)
    {
        $query = $this->pdo->prepare("SELECT * FROM `domains` WHERE `domain_name_fr` LIKE '%{$domain_name}%' OR `domain_name_en` LIKE '%{$domain_name}%'");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
}