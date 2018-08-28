<?php
/**
 * Created by PhpStorm.
 * User: codename-tkc
 * Date: 30/12/2017
 * Time: 17:40
 */

class DomainTagManager
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

    public function addDomain_tag($domain_tag_name_fr, $domain_tag_name_en, $domain_tag_site_id, $domain_tag_domain_id)
    {
        $sql = "INSERT INTO `domain_tags`(`domain_tag_name_fr`, `domain_tag_name_en`, `domain_tag_site_id`, `domain_tag_domain_id`) VALUES (?,?,?,?)";
        $query = $this->pdo->prepare($sql);
        return $query->execute(array($domain_tag_name_fr, $domain_tag_name_en, $domain_tag_site_id, $domain_tag_domain_id));
    }

    public function updateDomain_tag($domain_tag_id, $domain_tag_name_fr, $domain_tag_name_en, $domain_tag_site_id, $domain_tag_domain_id)
    {
        if ($domain_tag_id != null) {
            if ($domain_tag_name_fr != null) {
                $query = $this->pdo->prepare("UPDATE `domain_tags` SET `domain_tag_name_fr` = ? WHERE `domain_tag_id` = ?");
                $query->execute(array($domain_tag_name_fr, $domain_tag_id));
            }
            if ($domain_tag_name_en != null) {
                $query = $this->pdo->prepare("UPDATE `domain_tags` SET `domain_tag_name_en` = ? WHERE `domain_tag_id` = ?");
                $query->execute(array($domain_tag_name_en, $domain_tag_id));
            }
            if ($domain_tag_site_id != null) {
                $query = $this->pdo->prepare("UPDATE `domain_tags` SET `domain_tag_site_id` = ? WHERE `domain_tag_id` = ?");
                $query->execute(array($domain_tag_site_id, $domain_tag_id));
            }
            if ($domain_tag_domain_id != null) {
                $query = $this->pdo->prepare("UPDATE `domain_tags` SET `domain_tag_domain_id` = ? WHERE `domain_tag_id` = ?");
                $query->execute(array($domain_tag_domain_id, $domain_tag_id));
            }
        }
    }

    public function getDomain_tag()
    {
        $query = $this->pdo->prepare("SELECT * FROM `domain_tags`");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deregisterDomain_tag($domain_tag_id)
    {
        $query = $this->pdo->prepare("DELETE FROM `domain_tags` WHERE `domain_tag_id` = ?");
        return $query->execute(array($domain_tag_id));
    }

    public function getDomain_tagById($domain_tag_id)
    {
        $query = $this->pdo->prepare("SELECT * FROM `domain_tags` WHERE `domain_tag_id` = ?");
        $query->execute(array($domain_tag_id));
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * lang  = "fr" or otherwise it takes
     * english automatically
     */
    public function searchDomain_tag($domain_tag_name, $domain_id, $lang)
    {
        if ($lang == "fr") {
            $query = $this->pdo->prepare("SELECT * FROM `domain_tags` WHERE `domain_tag_name_fr` LIKE '%{$domain_tag_name}%' AND `domain_tag_domain_id` = {$domain_id}");
            $query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $query = $this->pdo->prepare("SELECT * FROM `domain_tags` WHERE `domain_tag_name_en` LIKE '%{$domain_tag_name}%' AND `domain_tag_domain_id` = {$domain_id}");
            $query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
        }

    }
}