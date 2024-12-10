<?php
namespace App\Model\Dao;

use App\Config\Database;
use App\Model\Entities\Remise;
use Exception;
use PDO;
use PDOException;

class RemiseDAO {
    private $db;
    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    } 
    public function getRemiseFromClient(): array {
        try {
            $stmt = $this->db->prepare("
                SELECT 
                    c.id AS client_id,
                    c.nom AS client_name,
                    YEAR(cmd.date) AS year,
                    SUM(cp.quantity * p.prix) AS total_achats
                FROM commande cmd
                JOIN commande_produit cp ON cp.idCommande = cmd.id
                JOIN produit p ON p.id = cp.idProduit
                JOIN client c ON c.id = cmd.idClient
                WHERE 
                    (c.remis_year IS NULL OR c.remis_year < YEAR(CURRENT_DATE()))
                GROUP BY 
                    c.id, 
                    c.nom, 
                    YEAR(cmd.date)
                ORDER BY 
                    year, 
                    client_name
            ");
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            $mappedResults = [];
            foreach ($results as $row) {
                $mappedResults[] = [
                    'client_id' => $row['client_id'],
                    'client_name' => $row['client_name'],
                    'year' => (int)$row['year'],
                    'total_achats' => (float)$row['total_achats']
                ];
            }
            
            return $mappedResults;
        } catch (PDOException $e) {
            throw new Exception("Error retrieving client remise: " . $e->getMessage(), 0, $e);
        } catch (Exception $e) {
            throw new Exception("Unexpected error in getRemiseFromClient: " . $e->getMessage(), 0, $e);
        }
    }
    public function calculateAndSaveRemise(int $idClient, int $year, float $totalAchats): bool {
            $remise = $totalAchats * 0.025;
            try {
            $this->db->beginTransaction();
        
            $stmt = $this->db->prepare("
                INSERT INTO remises (id_client, total_achats, remise, annee)
                VALUES (:id_client, :total_achats, :remise, :annee)
            ");
             $stmt->execute([
                'id_client' => $idClient,
                'total_achats' => $totalAchats,
                'remise' => $remise,
                'annee' => $year,
            ]);
            // Update user's prime year
            $userStmt = $this->db->prepare(
                "UPDATE client SET remis_year = :year WHERE id = :id"
            );
            $userStmt->execute([
                'year' => $year,
                'id' => $idClient
            ]);
            $this->db->commit();
            return $remise;
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de l'enregistrement de la remise : " . $e->getMessage());
        }
    }    
    public function getAllRemises(): array {
        try {
            // Modify the SQL query to join the remises with the client table to get the client name
            $query = "SELECT r.*, c.nom AS client_name
                      FROM remises r
                      JOIN client c ON r.id_client = c.id";
            $stmt = $this->db->query($query);
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            $remises = [];
            foreach ($results as $row) {
                $remise = new Remise(
                    $row['id'],
                    $row['id_client'],
                    $row['annee'],
                    $row['total_achats'],
                    $row['remise']
                );
                $remise->setClientName($row['client_name']);
    
                $remises[] = $remise;
            }
            return $remises;
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la récupération des remises : " . $e->getMessage());
        }
    }
    public function delete(int $id, int $clientId): bool {
        try {
            $this->db->beginTransaction();
    
            $updateStmt = $this->db->prepare("UPDATE client SET remis_year = 0 WHERE id = :client_id");
            $updateStmt->execute([':client_id' => $clientId]);
    
            $stmt = $this->db->prepare("DELETE FROM remises WHERE id = :id");
            $deleteResult = $stmt->execute([':id' => $id]);
    
            $this->db->commit();
    
            return $deleteResult;
        } catch (PDOException $e) {
            $this->db->rollBack();
            throw new Exception("Erreur lors de la suppression de la prime : " . $e->getMessage());
        }
    }
    
}