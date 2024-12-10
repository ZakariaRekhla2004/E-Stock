<?php

namespace App\Controller;

use App\Model\Dao\PrimeDAO;
use Exception;
use InvalidArgumentException;

class PrimeController
{
    private $primeDAO;

    public function __construct() {
        $this->primeDAO = new PrimeDAO();
    }

    
    public function index(): void
    {
        $view = './App/Views/PrimesRemisePage/Prime.php'; // Main view
        include_once './App/Views/Layout/Layout.php'; // Layout with the main view
    }
    public function primesCalculated(): void
    {
        $primes = $this->primeDAO->getAllPrime();
        $view = './App/Views/PrimesRemisePage/Prime.php';
        include_once './App/Views/Layout/Layout.php';
    }
    public function Calculate(int $commercialId, int $year, float $chiffreAffaire): void
    {
        try {
            error_log($year);
            $prime = $this->primeDAO->calculateAndSavePrime($commercialId, $year, $chiffreAffaire);
            
            header('Content-Type: application/json');
            echo json_encode([
                'success' => true, 
                'prime' => $prime
            ]);
            exit;
        } catch (Exception $e) {
            error_log($e->getMessage()); 
            header('Content-Type: application/json');
            http_response_code(500);
            echo json_encode([
                'success' => false, 
                'message' => $e->getMessage()
            ]);
            exit;
        }
    }
    public function primesNotCalculated(): void
    {

        $currentYear = date('Y');
        $commercials = $this->primeDAO->getAllPrimesFromCom();
        $view = './App/Views/PrimesRemisePage/WithoutPrime.php';
        include_once './App/Views/Layout/Layout.php';
    }
    public function deletePrimes(int $id, int $idCommercial): void {
        try {
            $result = $this->primeDAO->delete($id, $idCommercial);

            header('Content-Type: application/json'); 
          
            $response = [
                'success' => $result,
                'message' => $result ? 'Prime supprimée avec succès.' : 'Échec de la suppression de la prime.'
            ];
    
            echo json_encode($response);
            exit; 
           
        } catch (Exception $e) {
            echo json_encode([
                'success' => false,
                'message' => 'Erreur lors de la suppression de la prime : ' . $e->getMessage()
            ]);
        }
    }
    

    

}
