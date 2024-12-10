<?php

namespace App\Controller;

use App\Model\Dao\RemiseDAO;
use Exception;

class RemiseController
{
    private $remiseDao;

    public function __construct() {
        $this->remiseDao = new RemiseDAO();
    }

    public function index(): void
    {
        $view = './App/Views/PrimesRemisePage/Remise.php'; // Main view
        include_once './App/Views/Layout/Layout.php'; // Layout with the main view
    }

    public function remiseCalculated(): void
    {
        $remises = $this->remiseDao->getAllRemises();
        $view = './App/Views/PrimesRemisePage/Remise.php';
        include_once './App/Views/Layout/Layout.php';
    }
    public function remiseNotCalculated(): void
    {
        $currentYear = date('Y');
        $clients = $this->remiseDao->getRemiseFromClient();
        $view = './App/Views/PrimesRemisePage/WithoutRemise.php';
        include_once './App/Views/Layout/Layout.php';
    }
    public function Calculate(int $client_id, int $year, float $total_achats): void
{
    try {
        $remise = $this->remiseDao->calculateAndSaveRemise($client_id, $year, $total_achats);
        header('Content-Type: application/json');
        echo json_encode([
            'success' => true, 
            'remise' => $remise
        ]);
        exit;
    } catch (Exception $e) {
        error_log($e->getMessage()); // Log de l'erreur pour analyse
        header('Content-Type: application/json');
        http_response_code(500);
        echo json_encode([
            'success' => false, 
            'message' => $e->getMessage()
        ]);
        exit;
    }
}
public function deleteRemise(int $id, int $clientId): void {
    try {
        $result = $this->remiseDao->delete($id, $clientId);

        header(header: 'Content-Type: application/json'); 
      
        $response = [
            'success' => $result,
            'message' => $result ? 'remise supprimée avec succès.' : 'Échec de la suppression de la prime.'
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