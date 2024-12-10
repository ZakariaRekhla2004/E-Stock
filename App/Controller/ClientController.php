<?php

namespace App\Controller;

use App\Model\Dao\ClientDAO;
use App\Model\Entities\Client;
use InvalidArgumentException;
use Exception;
use App\Config\Auth;
use App\Model\Dao\AuditDAO;
use App\Model\Entities\Audit;
use App\Model\Enums\AuditActions;
use App\Model\Enums\AuditTables;
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

                $userId = Auth::getUser()->getId();
                $audit = new Audit(
                    null,
                    AuditTables::CLIENT->value,
                    AuditActions::CREATE->value,
                    'Le client  ' . $nom . ' ' . $prenom . ' a été créé !'
                    ,
                    date('Y-m-d H:i:s'),
                    $userId
                );
                $auditDAO = new AuditDAO();
                $auditDAO->logAudit($audit);

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

                $userId = Auth::getUser()->getId();
                $audit = new Audit(
                    null,
                    AuditTables::CLIENT->value,
                    AuditActions::UPDATE->value,
                    'Le client avec l\'ID ' . $id . ' a été mis à jour !'
                    ,
                    date('Y-m-d H:i:s'),
                    $userId
                );
                $auditDAO = new AuditDAO();
                $auditDAO->logAudit($audit);

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

            $userId = Auth::getUser()->getId();
            $audit = new Audit(
                null,
                AuditTables::CLIENT->value,
                AuditActions::DELETE->value,
                'Le client avec l\'ID ' . $id . ' a été supprimé !'
                ,
                date('Y-m-d H:i:s'),
                $userId
            );
            $auditDAO = new AuditDAO();
            $auditDAO->logAudit($audit);

            $_SESSION['success_message'] = 'Client supprimé avec succès.';
        } catch (Exception $e) {
            $_SESSION['error_message'] = 'Erreur : ' . $e->getMessage();
        }

        // Redirection après la suppression
        header('Location: /Client');
        exit;
    }

}
