<?php

namespace App\Controller;

use App\Model\Dao\ClientDAO;
use App\Model\Entities\Client;
use InvalidArgumentException;
use Exception;

class ClientController
{

    public function index(): void
    {
        $clientDAO = new ClientDAO();
        $clients = $clientDAO->getAll(); // Récupérer tous les clients

        $view = './App/Views/ClientPage/Main.php'; // Vue principale
        include_once './App/Views/Layout/Layout.php';
    }
    public function add(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nom = $_POST['nom'] ?? null;
            $prenom = $_POST['prenom'] ?? null;
            $adresse = $_POST['adresse'] ?? null;
            $ville = $_POST['ville'] ?? null;

            try {
                if (!$nom || !$prenom || !$adresse || !$ville) {
                    throw new InvalidArgumentException('Tous les champs doivent être remplis.');
                }

                $clientDAO = new ClientDAO();
                $client = new Client($nom, $prenom, $adresse, $ville, null);
                $clientDAO->create($client);

                $_SESSION['success_message'] = 'Client ajouté avec succès.';
            } catch (InvalidArgumentException $e) {
                $_SESSION['error_message'] = $e->getMessage();
            } catch (Exception $e) {
                $_SESSION['error_message'] = 'Erreur : ' . $e->getMessage();
            }

            header('Location: /Client');
            exit;
        }
    }

    public function update($id): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nom = $_POST['nom'] ?? null;
            $prenom = $_POST['prenom'] ?? null;
            $adresse = $_POST['adresse'] ?? null;
            $ville = $_POST['ville'] ?? null;
    
            try {
                if (!$nom || !$prenom || !$adresse || !$ville) {
                    throw new InvalidArgumentException('Tous les champs doivent être remplis.');
                }
    
                $clientDAO = new ClientDAO();
                $client = new Client($nom, $prenom, $adresse, $ville, $id);
                $clientDAO->update($client);
    
                $_SESSION['success_message'] = 'Client modifié avec succès.';
            } catch (InvalidArgumentException $e) {
                $_SESSION['error_message'] = $e->getMessage();
            } catch (Exception $e) {
                $_SESSION['error_message'] = 'Erreur : ' . $e->getMessage();
            }
    
            header('Location: /Client');
            exit;
        }
    }
    

    public function delete($id): void
    {
        try {
            if (!is_numeric($id)) {
                throw new InvalidArgumentException('ID invalide.');
            }
    
            $clientDAO = new ClientDAO();
            $clientDAO->delete($id);
    
            $_SESSION['success_message'] = 'Client supprimé avec succès.';
        } catch (Exception $e) {
            $_SESSION['error_message'] = 'Erreur : ' . $e->getMessage();
        }
    
        // Redirection après la suppression
        header('Location: /Client');
        exit;
    }
    
    
    
    
    
}
