<?php
namespace App\Model\Dao;

use PDO;
use App\Config\Database;
use App\Model\Entities\Audit;

class AuditDAO
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    // Save audit log
    public function logAudit(Audit $audit)
    {
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
    public function getAll()
    {
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
    public function getById($id)
    {
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

    public function getAuditsWithUserNames(): array
    {
        // Use the $this->db instance initialized in the constructor
        $sql = "
        SELECT 
        audit.id,
        audit.table_name,
        audit.action_type,
        audit.action_description,
        audit.action_date,
        audit.user_id,
        users.nom AS user_nom FROM audit JOIN users ON audit.user_id = users.user_id;
    ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        $audits = [];
        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $audit = new Audit();
            $audit->setId($row['id']);
            $audit->setTableName($row['table_name']);
            $audit->setActionType($row['action_type']);
            $audit->setActionDescription($row['action_description']);
            $audit->setActionDate($row['action_date']);
            $audit->setUserId($row['user_id']);

            // Dynamically add the user_nom property
            $audit->user_nom = $row['user_nom'];

            $audits[] = $audit;
        }

        return $audits;
    }

}
?>