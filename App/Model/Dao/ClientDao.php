<?php
namespace App\Model\Dao;

use PDO;
use App\Config\Database;
use App\Model\Entities\Client;
use PDOException;
use Exception;

class ClientDao
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    // Create a new client
    public function create(Client $client)
    {
        try {
            $query = 'INSERT INTO client (nom, prenom, adresse, ville) VALUES (:nom, :prenom, :adresse, :ville)';
            $stmt = $this->db->prepare($query);

            $stmt->bindValue(':nom', $client->getNom());
            $stmt->bindValue(':prenom', $client->getPrenom());
            $stmt->bindValue(':adresse', $client->getAdresse());
            $stmt->bindValue(':ville', $client->getVille());

            $stmt->execute();

            return $this->db->lastInsertId(); // Retourne l'ID du dernier enregistrement
        } catch (PDOException $e) {
            // En cas d'erreur, affichez les détails pour debug
            throw new Exception('Erreur lors de l\'insertion dans la base de données : ' . $e->getMessage());
        }
    }

    // Read all clients
    // Get all active clients
    public function getAll()
    {
        $query = 'SELECT * FROM client WHERE is_deleted = FALSE';
        $stmt = $this->db->query($query);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $clients = [];
        foreach ($results as $row) {
            $clients[] = new Client($row['nom'], $row['prenom'], $row['adresse'], $row['ville'], $row['id']);
        }
        return $clients;
    }

    // Get a client by ID (only active)
    public function getById($id)
    {
        $query = 'SELECT * FROM client WHERE id = :id AND is_deleted = FALSE';
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            return new Client($row['nom'], $row['prenom'], $row['adresse'], $row['ville'], $row['id']);
        }
        return null;
    }

    // Read a client by ID

    // Update a client
    public function update(Client $client): void
    {
        $stmt = $this->db->prepare('UPDATE client SET nom = :nom, prenom = :prenom, adresse = :adresse, ville = :ville WHERE id = :id');
        $stmt->execute([
            'nom' => $client->getNom(),
            'prenom' => $client->getPrenom(),
            'adresse' => $client->getAdresse(),
            'ville' => $client->getVille(),
            'id' => $client->getId(),
        ]);
    }

    // Restore a soft-deleted client
    public function restore(int $id): void
    {
        $stmt = $this->db->prepare('UPDATE client SET is_deleted = FALSE WHERE id = :id');
        $stmt->execute(['id' => $id]);
    }

    // Soft delete a client
    public function delete(int $id): void
    {
        $stmt = $this->db->prepare('UPDATE client SET is_deleted = TRUE WHERE id = :id');
        $stmt->execute(['id' => $id]);
    }
}
?>
