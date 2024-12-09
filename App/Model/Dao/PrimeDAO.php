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
        $stmt = $this->db->prepare("
            SELECT 
                c.nom AS commercial_name, 
                YEAR(cmd.date_commande) AS year, 
                SUM(cmd.montant) AS chiffre_affaire
            FROM commandes cmd
            JOIN users c ON cmd.id_commercial = c.id
            WHERE c.yerar_prime != YEAR(CURDATE())
            GROUP BY year, c.nom
            ORDER BY year, c.nom
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC); 
    }
   


    /**
     * Calculer et enregistrer une prime pour un commercial et une année donnée
     */
    public function calculateAndSavePrime(int $commercialId, int $year, float $chiffreAffaire): float {
        $prime = $chiffreAffaire * 0.1;
    
        try {
            $stmt = $this->db->prepare("
                INSERT INTO primes (id_commercial, chiffre_affaire, prime, year)
                VALUES (:id_commercial, :chiffre_affaire, :prime, :year)
            ");
    
            $success = $stmt->execute([
                'id_commercial' => $commercialId,
                'chiffre_affaire' => $chiffreAffaire,
                'prime' => $prime,
                'year' => $year,
            ]);
    
            return $success ? $prime : 0.0;
        } catch (PDOException $e) {
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
    public function getPrimesFromComByYear(int $year): array {
       
        $stmt = $this->db->prepare("
        SELECT c.nom AS commercial_name, 
            YEAR(cmd.date_commande) AS year, 
            SUM(cmd.montant) AS chiffre_affaire
            FROM commandes cmd
            JOIN users c ON cmd.id_commercial = c.id
            WHERE c.prime != YEAR(CURDATE())
            AND cmd.time= :year
            GROUP BY year, c.nom
            ORDER BY year, c.nom");
        $stmt->execute(['year' => $year]);

        $primes = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $primes[] = new Prime(
                $row['id'],
                $row['id_commercial'],
                $row['chiffre_affaire'],
                $row['year']
            );
        }
        return $primes;
    }
    public function delete(int $id): bool {
        $stmt = $this->db->prepare("DELETE FROM primes WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }
    public function getAllPrime(): array {
        try {
            // Prepare the SQL query to fetch all primes where deleted = 0 (if needed)
            $query = "SELECT * FROM primes";
            $stmt = $this->db->query($query);
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            $primes = [];
            // Iterate over the results and map each row to a Prime object
            foreach ($results as $row) {
                $primes[] = new Prime(
                    $row['id'], $row['id_commercial'], $row['chiffre_affaire'], 
                    $row['prime'], $row['year']
                );
            }
            return $primes;
        } catch (PDOException $e) {
            // Throw an exception in case of any error
            throw new Exception("Erreur lors de la récupération des primes : " . $e->getMessage());
        }
    }
    public function getAllPrimeByYear(int $year): array {
        try {
            // Prepare the SQL query to fetch all primes where deleted = 0 (if needed)
            $stmt = $this->db->prepare("SELECT * FROM primes WHERE year = :year");
            $stmt->execute(['year' => $year]);
    
            $primes = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $primes[] = new Prime(
                    $row['id'],
                    $row['id_commercial'],
                    $row['chiffre_affaire'],
                    $row['year']
                );
            }
            return $primes;
        } catch (PDOException $e) {
            // Throw an exception in case of any error
            throw new Exception("Erreur lors de la récupération des primes : " . $e->getMessage());
        }
    }

}
