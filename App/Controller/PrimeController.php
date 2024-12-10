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
    public function deletePrimes(): void {
        try {
            $primeId = $_POST['primeId'] ?? null;
            $idCommercial = $_POST['idCommercial'] ?? null;
            $result = $this->primeDAO->delete( $primeId,$idCommercial);
    
            // Message de succès ou d'échec
            if ($result) {
                $_SESSION['success_message'] = 'Prime supprimée avec succès.';
            } else {
                $_SESSION['error_message'] = 'Échec de la suppression de la prime.';
            }
            
        } catch (Exception $e) {
            $_SESSION['error_message'] = 'Erreur lors de la suppression de la prime : ' . $e->getMessage();
        }
    
        // Redirection vers la page des primes après suppression
        header('Location: /Prime');
        exit;
    }
    
    

    

}
