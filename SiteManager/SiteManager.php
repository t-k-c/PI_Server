<?php
/**
 * Created by PhpStorm.
 * User: codename-tkc
 * Date: 29/12/2017
 * Time: 18:47
 */

class SiteManager
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

    public function registerSite($site_location_description, $site_name, $site_longitude, $site_latitude, $site_contact, $site_logo, $site_since, $site_workers_number,
                                 $site_visibility, $site_created_at, $site_working_period, $site_user_id, $site_description_en, $site_description_fr)
    {
        $sql = "INSERT INTO `sites`(`site_location_description`,`site_name`,`site_longitude`, `site_latitude`, `site_contact`, 
`site_logo`, `site_since`, `site_workers_number`, `site_visibility`, `site_created_at`, `site_working_period`, 
`site_description_en`, `site_description_fr`, `site_user_id`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $query = $this->pdo->prepare($sql);
        $query->execute(array($site_location_description, $site_name, $site_longitude, $site_latitude, $site_contact,
            $site_logo, $site_since, $site_workers_number, $site_visibility, $site_created_at, $site_working_period,
            $site_description_en, $site_description_fr, $site_user_id));
    }

    public function modifySite($site_id, $site_location_description, $site_name, $site_longitude, $site_latitude, $site_contact, $site_logo, $site_since, $site_workers_number,
                               $site_visibility, $site_created_at, $site_working_period, $site_user_id, $site_description_en, $site_description_fr)
    {
        if ($site_id != null) {
            if ($site_name != null) {
                $query = $this->pdo->prepare("UPDATE `sites` SET `site_name` = ? WHERE `site_id` = ?");
                $query->execute(array($site_name, $site_id));
            }
            if ($site_longitude != null) {
                $query = $this->pdo->prepare("UPDATE `sites` SET `site_longitude` = ? WHERE `site_id` = ?");
                $query->execute(array($site_longitude, $site_id));
            }
            if ($site_latitude != null) {
                $query = $this->pdo->prepare("UPDATE `sites` SET `site_latitude` = ? WHERE `site_id` = ?");
                $query->execute(array($site_latitude, $site_id));
            }
            if ($site_contact != null) {
                $query = $this->pdo->prepare("UPDATE `sites` SET `site_contact` = ? WHERE `site_id` = ?");
                $query->execute(array($site_contact, $site_id));
            }
            if ($site_logo != null) {
                $query = $this->pdo->prepare("UPDATE `sites` SET `site_logo` = ? WHERE `site_id` = ?");
                $query->execute(array($site_logo, $site_id));
            }
            if ($site_since != null) {
                $query = $this->pdo->prepare("UPDATE `sites` SET `site_since` = ? WHERE `site_id` = ?");
                $query->execute(array($site_since, $site_id));
            }
            if ($site_workers_number != null) {
                $query = $this->pdo->prepare("UPDATE `sites` SET `site_workers_number` = ? WHERE `site_id` = ?");
                $query->execute(array($site_workers_number, $site_id));
            }
            if ($site_visibility != null) {
                $query = $this->pdo->prepare("UPDATE `sites` SET `site_visibility` = ? WHERE `site_id` = ?");
                $query->execute(array($site_visibility, $site_id));
            }
            if ($site_created_at != null) {
                $query = $this->pdo->prepare("UPDATE `sites` SET `site_created_at` = ? WHERE `site_id` = ?");
                $query->execute(array($site_created_at, $site_id));
            }
            if ($site_working_period != null) {
                $query = $this->pdo->prepare("UPDATE `sites` SET `site_working_period` = ? WHERE `site_id` = ?");
                $query->execute(array($site_working_period, $site_id));
            }
            if ($site_user_id != null) {
                $query = $this->pdo->prepare("UPDATE `sites` SET `site_user_id` = ? WHERE `site_id` = ?");
                $query->execute(array($site_user_id, $site_id));
            }
            if ($site_description_en != null) {
                $query = $this->pdo->prepare("UPDATE `sites` SET `site_description_en` = ? WHERE `site_id` = ?");
                $query->execute(array($site_description_en, $site_id));
            }
            if ($site_description_fr != null) {
                $query = $this->pdo->prepare("UPDATE `sites` SET `site_description_fr` = ? WHERE `site_id` = ?");
                $query->execute(array($site_description_fr, $site_id));
            }
            if ($site_location_description != null) {
                $query = $this->pdo->prepare("UPDATE `sites` SET `site_location_description` = ? WHERE `site_id` = ?");
                $query->execute(array($site_location_description, $site_id));
            }
        }
    }

    public function searchSite($site_name)
    {
        $query = $this->pdo->prepare("SELECT * FROM `sites` WHERE `site_name` LIKE '%{$site_name}%'");
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_ASSOC);
        return $results;
    }

    public function getSites()
    {
        $query = $this->pdo->prepare("SELECT * FROM `sites`");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    public function deregisterSite($site_id){
        $query = $this->pdo->prepare("DELETE FROM `sites` WHERE `site_id` = ?");
        $query->execute(array($site_id));
        $query2 = $this->pdo->prepare("DELETE FROM `domain_mappings` WHERE `location_id` = ?");
        $query2->execute(array($site_id));
    }
    public function getSiteById($site_id){
        $query = $this->pdo->prepare("SELECT * FROM `sites` WHERE `site_id` = ?");
        $query->execute(array($site_id));
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
}

/*$object = new SiteManager();
$object->registerSite('site location modi','express modi', 12.999,
    -0.0999, '{"phone":"677641804 modi","email":"contact@contact.com modi"}',
    "logo link modi", "2017-10-12", 98,
    1, "2017-09-12",
    '{"data":"json modi"}', 2,
    "english modiss",
    "french modiss");*/
//print_r($object->getSiteById(5));

