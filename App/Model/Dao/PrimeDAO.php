<?php
namespace App\Model\Dao;

use App\Config\Database;
use App\Model\Entities\Prime;
use Exception;
use PDO;
use PDOException;

class PrimeDAO {
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }
    public function getAllPrimesFromCom(): array {
        try {
            $stmt = $this->db->prepare("
                SELECT 
                    u.user_id AS commercial_id,
                    u.nom AS commercial_name, 
                    YEAR(cmd.date) AS year,
                    SUM(cp.quantity * p.prix) AS chiffre_affaire
                FROM users u
                JOIN commande cmd ON cmd.idUser = u.user_id
                JOIN commande_produit cp ON cp.idCommande = cmd.id
                JOIN produit p ON p.id = cp.idProduit
                WHERE u.role = 'COMERCIAL' 
                AND u.year_prime != YEAR(CURRENT_DATE())
                GROUP BY 
                    u.user_id,
                    u.nom, 
                    YEAR(cmd.date)
                ORDER BY 
                    year, 
                    commercial_name
            ");
            
            $stmt->execute();
            
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            $mappedResults = [];
            foreach ($results as $row) {
                $mappedResults[] = [
                    'commercial_id' => $row['commercial_id'],
                    'commercial_name' => $row['commercial_name'],
                    'year' => (int)$row['year'],
                    'chiffre_affaire' => (float)$row['chiffre_affaire']
                ];
            }
            
            return $mappedResults;
        } catch (PDOException $e) {
            // Handle the exception appropriately
            throw new Exception("Error retrieving commercial primes: " . $e->getMessage());
        }
    }

    /**
     * Calculer et enregistrer une prime pour un commercial et une année donnée
     */
    public function calculateAndSavePrime(int $commercialId, int $year, float $chiffreAffaire): float {
        $prime = $chiffreAffaire * 0.1;
    
        try {
            $this->db->beginTransaction();
    
            // Insert prime record
            $primeStmt = $this->db->prepare(
                "INSERT INTO primes (id_commercial, chiffre_affaire, prime, year) 
                 VALUES (:id_commercial, :chiffre_affaire, :prime, :year)"
            );
            $primeStmt->execute([
                'id_commercial' => $commercialId,
                'chiffre_affaire' => $chiffreAffaire,
                'prime' => $prime,
                'year' => $year,
            ]);
    
            // Update user's prime year
            $userStmt = $this->db->prepare(
                "UPDATE users SET year_prime = :year WHERE user_id = :id"
            );
            $userStmt->execute([
                'year' => $year,
                'id' => $commercialId
            ]);
    
            $this->db->commit();
            return $prime;
    
        } catch (PDOException $e) {
            $this->db->rollBack();
            throw new Exception("Error saving the prime: " . $e->getMessage());
        }
    }
    
    /**
     * Vérifier si une prime existe déjà pour un commercial et une année donnée
     */
    public function getPrimeByCommercialAndYear(int $idCommercial, int $year): ?Prime {
        $stmt = $this->db->prepare("
            SELECT * FROM primes WHERE id_commercial = :id_commercial AND year = :year
        ");
        $stmt->execute([
            'id_commercial' => $idCommercial,
            'year' => $year,
        ]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            return new Prime(
                $row['id'],
                $row['id_commercial'],
                $row['chiffre_affaire'],
                $row['year']
            );
        }

        return null;
    }

    /**
     * Récupérer toutes les primes pour une année donnée
     */
   
     public function delete(int $id,int $idCommercial): bool {
        try {
            $this->db->beginTransaction();
            $updateStmt = $this->db->prepare("
                UPDATE users 
                SET year_prime = 0 
                WHERE user_id = :id
            ");
            $updateStmt->execute([':id' => $idCommercial]);
    
            $deleteStmt = $this->db->prepare("
                DELETE FROM primes 
                WHERE id = :id
            ");
            $deleteStmt->execute([':id' => $id]);
    
            $this->db->commit();
            return true;
    
        } catch (Exception $e) {
            $this->db->rollBack();
            throw new Exception("Erreur lors de la suppression de la prime : " . $e->getMessage());
        }
    }
    



    // public function getAllPrime(): array {
    //     try {
    //         // Prepare the SQL query to fetch all primes where deleted = 0 (if needed)
    //         $query = "SELECT * FROM primes";
    //         $stmt = $this->db->query($query);
    //         $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    //         $primes = [];
    //         // Iterate over the results and map each row to a Prime object
    //         foreach ($results as $row) {
    //             $primes[] = new Prime(
    //                 $row['id'], $row['id_commercial'], $row['chiffre_affaire'], 
    //                 $row['prime'], $row['year']
    //             );
    //         }
    //         return $primes;
    //     } catch (PDOException $e) {
    //         // Throw an exception in case of any error
    //         throw new Exception("Erreur lors de la récupération des primes : " . $e->getMessage());
    //     }
    // }
    public function getAllPrime(): array {
        try {
            // Prepare the SQL query to join primes with users to get commercial name
            $query = "SELECT p.*, u.nom AS commercial_name 
                      FROM primes p
                      LEFT JOIN users u ON p.id_commercial = u.user_id";
            $stmt = $this->db->query($query);
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
     
            $primes = [];
            // Iterate over the results and map each row to a Prime object
            foreach ($results as $row) {
                $prime = new Prime(
                    $row['id'], 
                    $row['id_commercial'], 
                    $row['chiffre_affaire'],
                    $row['prime'], 
                    $row['year']
                );
                
                // Add a method to set commercial name
                $prime->setCommercialName($row['commercial_name']);
                
                $primes[] = $prime;
            }
            return $primes;
        } catch (PDOException $e) {
            // Throw an exception in case of any error
            throw new Exception("Erreur lors de la récupération des primes : " . $e->getMessage());
        }
    }

}
