<?php
namespace App\Model\Dao;

use App\Config\Database;
use Exception;
use PDO;
use PDOException;
use Remise;

class RemiseDAO {
    private $db;
    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    } 
    public function getRemiseFromClient(): array {
        $stmt = $this->db->prepare("
            SELECT 
                cl.name AS client_name, 
                YEAR(cmd.date_commande) AS year, 
                SUM(cmd.montant) AS total_achats
            FROM commandes cmd
            JOIN clients cl ON cmd.id_client = cl.id
            WHERE cl.remise_year != YEAR(CURDATE())
            GROUP BY year, cl.name
            ORDER BY year, cl.name

        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC); 
    }
    public function calculateAndSaveRemise(int $idClient, int $year, float $totalAchats): bool {
        try {
            $remise = $totalAchats * 0.025;
    
            $stmt = $this->db->prepare("
                INSERT INTO remises (id_client, total_achats, remise, year)
                VALUES (:id_client, :total_achats, :remise, :year)
            ");
            return $stmt->execute([
                'id_client' => $idClient,
                'total_achats' => $totalAchats,
                'remise' => $remise,
                'year' => $year,
            ]);
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de l'enregistrement de la remise : " . $e->getMessage());
        }
    }    
    public function getAllRemises(): array {
        try {
            $query = "SELECT * FROM remises";
            $stmt = $this->db->query($query);
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            $remises = [];
            foreach ($results as $row) {
                $remises[] = new Remise(
                    $row['id'], 
                    $row['id_client'], 
                    $row['total_achats'], 
                    $row['remise'], 
                    $row['year']
                );
            }
            return $remises;
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la récupération des remises : " . $e->getMessage());
        }
    }
    public function delete(int $id): bool {
        $stmt = $this->db->prepare("DELETE FROM remises WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }
}