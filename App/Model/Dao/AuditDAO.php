<?php
namespace App\Model\Dao;

use PDO;
use App\Config\Database;
use App\Model\Entities\Audit;

class AuditDAO {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    // Save audit log
    public function logAudit(Audit $audit) {
        $query = "INSERT INTO audit (table_name, action_type, action_description, action_date, user_id) 
                  VALUES (:table_name, :action_type, :action_description, :action_date, :user_id)";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':table_name', $audit->getTableName());
        $stmt->bindValue(':action_type', $audit->getActionType());
        $stmt->bindValue(':action_description', $audit->getActionDescription());
        $stmt->bindValue(':action_date', $audit->getActionDate());
        $stmt->bindValue(':user_id', $audit->getUserId());
        $stmt->execute();
        return $this->db->lastInsertId();
    }

    // Get all audit logs
    public function getAll() {
        $query = "SELECT * FROM audit";
        $stmt = $this->db->query($query);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $audits = [];
        foreach ($results as $row) {
            $audits[] = new Audit($row['id'], $row['table_name'], $row['action_type'], $row['action_description'], $row['action_date'], $row['user_id']);
        }
        return $audits;
    }

    // Get audit log by ID
    public function getById($id) {
        $query = "SELECT * FROM audit WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            return new Audit($row['id'], $row['table_name'], $row['action_type'], $row['action_description'], $row['action_date'], $row['user_id']);
        }
        return null;
    }
}
?>
