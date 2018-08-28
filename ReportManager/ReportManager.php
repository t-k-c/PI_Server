<?php
/**
 * Created by PhpStorm.
 * User: codename-tkc
 * Date: 30/12/2017
 * Time: 18:05
 */

class ReportManager
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

    public function addReport($report_location_id, $report_content, $report_user_id)
    {
        $sql = "INSERT INTO `reports`(`report_location_id`, `report_content`, `report_user_id`) VALUES (?,?,?)";
        $query = $this->pdo->prepare($sql);
        return $query->execute(array($report_location_id, $report_content, $report_user_id));
    }

    public function updateReport($report_id, $report_location_id, $report_content, $report_user_id)
    {
        if ($report_id != null) {
            if ($report_location_id != null) {
                $query = $this->pdo->prepare("UPDATE `reports` SET `report_location_id` = ? WHERE `report_id` = ?");
                $query->execute(array($report_location_id, $report_id));
            }
            if ($report_content != null) {
                $query = $this->pdo->prepare("UPDATE `reports` SET `report_content` = ? WHERE `report_id` = ?");
                $query->execute(array($report_content, $report_id));
            }
            if ($report_user_id != null) {
                $query = $this->pdo->prepare("UPDATE `reports` SET `report_user_id` = ? WHERE `report_id` = ?");
                $query->execute(array($report_user_id, $report_id));
            }
        }
    }

    public function getReport()
    {
        $query = $this->pdo->prepare("SELECT * FROM `reports`");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deregisterReport($report_id)
    {
        $query = $this->pdo->prepare("DELETE FROM `reports` WHERE `report_id` = ?");
        return $query->execute(array($report_id));
    }

    public function getReportById($report_id)
    {
        $query = $this->pdo->prepare("SELECT * FROM `reports` WHERE `report_id` = ?");
        $query->execute(array($report_id));
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getSiteReports($site_id)
    {
        $query = $this->pdo->prepare("SELECT * FROM `reports` WHERE `report_location_id` = ?");
        $query->execute(array($site_id));
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUserReports($user_id)
    {
        $query = $this->pdo->prepare("SELECT * FROM `reports` WHERE `report_user_id` = ?");
        $query->execute(array($user_id));
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
}