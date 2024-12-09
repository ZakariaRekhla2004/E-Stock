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

    public function getByCommandeId($idCommande) {
        $query = "SELECT * FROM commande_produit WHERE idCommande = :idCommande";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':idCommande', $idCommande);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
