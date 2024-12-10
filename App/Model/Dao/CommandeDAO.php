<?php

namespace App\Model\Dao;

use PDO;
use App\Config\Database;
use App\Model\Entities\Commande;
use Exception;

class CommandeDAO {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function create($idClient, $idUser)
    {
        try {
            $query = "INSERT INTO commande (idClient, idUser, date) VALUES (:idClient, :idUser, NOW())";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':idClient', $idClient, PDO::PARAM_INT);
            $stmt->bindParam(':idUser', $idUser, PDO::PARAM_INT);
            $stmt->execute();

            return $this->db->lastInsertId(); // Retourne l'ID de la commande
        } catch (Exception $e) {
            throw new Exception('Erreur lors de la création de la commande: ' . $e->getMessage());
        }
    }

    // Ajoute un produit à une commande
    public function addProductToCommande($idCommande, $idProduit, $quantity)
    {
        try {
            $query = "INSERT INTO commande_produit (idCommande, idProduit, quantity) VALUES (:idCommande, :idProduit, :quantity)";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':idCommande', $idCommande, PDO::PARAM_INT);
            $stmt->bindParam(':idProduit', $idProduit, PDO::PARAM_INT);
            $stmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);
            $stmt->execute();
            echo "hahaha";
        } catch (Exception $e) {
            throw new Exception('Erreur lors de l\'ajout du produit à la commande: ' . $e->getMessage());
        }
    }

    public function getById($id) {
        $query = "SELECT * FROM commande WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return new Commande($row['id'], $row['date'], $row['idUser'], $row['idClient']);
        }
        return null;
    }

    public function getAllWithDetails(): array
{
    $query = "
        SELECT c.id, c.date, cl.nom AS client_nom, cl.prenom AS client_prenom, 
               SUM(pc.quantity * p.prix) AS total
        FROM commande c
        JOIN client cl ON c.idClient = cl.id
        JOIN commande_produit pc ON c.id = pc.idCommande
        JOIN produit p ON pc.idProduit = p.id
        GROUP BY c.id, c.date, cl.nom, cl.prenom
        ORDER BY c.date DESC
    ";

    $stmt = $this->db->query($query);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $results; // Retourner les résultats sous forme de tableau associatif
}

public function getByCommandeId($commandeId): array
{
    $query = "
        SELECT 
            pc.idCommande,
            p.id AS idProduit,
            p.designation AS nom,
            p.prix,
            pc.quantity
        FROM commande_produit pc
        JOIN produit p ON pc.idProduit = p.id
        WHERE pc.idCommande = :commandeId
    ";

    $stmt = $this->db->prepare($query);
    $stmt->bindParam(':commandeId', $commandeId, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC); // Retourne toutes les informations nécessaires
}


public function getTotalOrders(): int
{
    $query = "SELECT COUNT(*) as total FROM commande";
    $stmt = $this->db->query($query);
    return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
}

public function getTotalRevenue(): float
{
    $query = "SELECT SUM(p.prix * cp.quantity) as total FROM commande_produit cp 
              JOIN produit p ON cp.idProduit = p.id";
    $stmt = $this->db->query($query);
    return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
}


public function getMonthlySales(): array
{
    $query = "SELECT DATE_FORMAT(c.date, '%Y-%m') as mois, SUM(p.prix * cp.quantity) as total 
              FROM commande c 
              JOIN commande_produit cp ON c.id = cp.idCommande 
              JOIN produit p ON cp.idProduit = p.id 
              GROUP BY mois ORDER BY mois ASC";
    $stmt = $this->db->query($query);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
}
