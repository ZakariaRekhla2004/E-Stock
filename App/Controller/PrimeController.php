<?php

namespace App\Controller;

use App\Model\Dao\PrimeDAO;
use App\Model\Dao\PrimesPDF;
use Exception;
use InvalidArgumentException;
use App\Config\Auth;
use App\Model\Dao\AuditDAO;
use App\Model\Entities\Audit;
use App\Model\Enums\AuditActions;
use App\Model\Enums\AuditTables;

class PrimeController
{
    private $primeDAO;

    public function __construct()
    {
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
    public function deletePrimes(): void
    {
        try {
            $primeId = $_POST['primeId'] ?? null;
            $idCommercial = $_POST['idCommercial'] ?? null;
            $result = $this->primeDAO->delete($primeId, $idCommercial);

            // Message de succès ou d'échec
            if ($result) {
                $userId = Auth::getUser()->getId();
                $audit = new Audit(
                    null,
                    AuditTables::PRIME->value,
                    AuditActions::DELETE->value,
                    'Le prime avec l\'id ' . $primeId . ' a été supprimée !'
                    ,
                    date('Y-m-d H:i:s'),
                    $userId
                );
                $auditDAO = new AuditDAO();
                $auditDAO->logAudit($audit);
                $_SESSION['success_message'] = 'Prime supprimée avec succès.';
            } else {
                $_SESSION['error_message'] = 'Échec de la suppression de la prime.';
            }

        } catch (Exception $e) {
            $_SESSION['error_message'] = 'Erreur lors de la suppression de la prime : ' . $e->getMessage();
        }

        // Redirection vers la page des primes après suppression
        header('Location: /prime');
        exit;
    }


    public function generatePDF()
    {
        $primes = $this->primeDAO->getAllPrime();
        $pdf = new PrimesPDF($primes);
        $pdf->RenderPDF();
    }


}
