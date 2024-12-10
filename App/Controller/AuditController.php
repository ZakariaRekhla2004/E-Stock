<?php

namespace App\Controller;

use App\Model\Dao\AuditDAO;

class AuditController
{
    /**
     * Affiche tous les enregistrements d'audit.
     */
    public function index(): void
    {
        try {
            $auditDAO = new AuditDAO();

            // Fetch audits with user names
            $audits = $auditDAO->getAuditsWithUserNames();

            if (empty($audits)) {
                $audits = [];
            }

            $view = './App/Views/AuditPage/AuditPage.php';
            include_once './App/Views/Layout/Layout.php';
        } catch (\Exception $e) {
            $_SESSION['error_message'] = 'Erreur lors de la récupération des audits : ' . $e->getMessage();
            header('Location: /Error');
            exit;
        }
    }


    public function getAll(): array
    {
        $query = "
        SELECT 
            audits.*, 
            users.name AS user_name 
        FROM audits
        JOIN users ON audits.user_id = users.id
    ";

        $statement = $this->db->prepare($query);
        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);

        $audits = [];
        foreach ($results as $row) {
            $audit = new Audit(); // Instance de l'objet Audit
            $audit->setId($row['id']);
            $audit->setTableName($row['table_name']);
            $audit->setActionType($row['action_type']);
            $audit->setActionDescription($row['action_description']);
            $audit->setActionDate($row['action_date']);
            $audit->setUserId($row['user_id']);
            $audit->user_name = $row['user_name'];
            $audits[] = $audit;
        }

        return $audits;
    }


}

?>