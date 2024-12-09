<?php

namespace App\Model\Dao;

use PDO;
use App\Config\Database;
use App\Model\Entities\ProduitCommande;

class ProduitCommandeDAO {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function create(ProduitCommande $produitCommande) {
        $query = "INSERT INTO commande_produit (idCommande, idProduit, quantity) VALUES (:idCommande, :idProduit, :quantity)";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':idCommande', $produitCommande->getIdCommande());
        $stmt->bindValue(':idProduit', $produitCommande->getIdProduit());
        $stmt->bindValue(':quantity', $produitCommande->getQuantity());
        $stmt->execute();
    }

    public function getByCommandeId($commandeId): array
    {
        $query = "
            SELECT 
                pc.idCommande,
                p.id AS idProduit,
                p.designation AS nom,
                p.prix,
                p.pathImage,
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
    
}
