<?php

namespace App\Model\Dao;

use PDO;
use App\Config\Database;
use App\Model\Entities\Produit;
use PDOException;
use Exception;

class ProduitDAO {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    // Create a new product
    public function create(Produit $produit) {
        try {
            // Vérifier si la catégorie associée existe et n'est pas supprimée
            $categoryCheckQuery = "SELECT COUNT(*) FROM categorie WHERE id = :idCategorie AND deleted = 0";
            $categoryCheckStmt = $this->db->prepare($categoryCheckQuery);
            $categoryCheckStmt->bindValue(':idCategorie', $produit->getIdCategorie(), PDO::PARAM_INT);
            $categoryCheckStmt->execute();
            $categoryExists = $categoryCheckStmt->fetchColumn();

            if ($categoryExists == 0) {
                throw new Exception("Impossible d'ajouter le produit. La catégorie associée est supprimée ou inexistante.");
            }

            // Insérer le produit
            $query = "INSERT INTO produit (designation, prix, qtt, deleted, pathImage, idCategorie) 
                      VALUES (:designation, :prix, :qtt, :deleted, :pathImage, :idCategorie)";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':designation', $produit->getDesignation());
            $stmt->bindValue(':prix', $produit->getPrix());
            $stmt->bindValue(':qtt', $produit->getQtt());
            $stmt->bindValue(':deleted', $produit->getDeleted());
            $stmt->bindValue(':pathImage', $produit->getPathImage());
            $stmt->bindValue(':idCategorie', $produit->getIdCategorie(), PDO::PARAM_INT);
            $stmt->execute();

            return $this->db->lastInsertId();
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de l'ajout du produit : " . $e->getMessage());
        }
    }

    // Lire tous les produits
    public function getAll() {
        try {
            $query = "SELECT * FROM produit WHERE deleted = 0";
            $stmt = $this->db->query($query);
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $products = [];
            foreach ($results as $row) {
                $products[] = new Produit(
                    $row['id'], $row['designation'], $row['prix'], 
                    $row['qtt'], $row['pathImage'], $row['deleted'], $row['idCategorie']
                );
            }
            return $products;
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la récupération des produits : " . $e->getMessage());
        }
    }
    public function getAllForPannel() {
        try {
            $query = "SELECT * FROM produit WHERE deleted = 0 AND qtt > 0";
            $stmt = $this->db->query($query);
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            // Debugging
            if (empty($results)) {
                error_log("Aucun produit avec une quantité supérieure à 0 trouvé.");
            }
    
            return $results; // Retourne directement le tableau associatif
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la récupération des produits : " . $e->getMessage());
        }
    }
    

    // Lire un produit par ID
    public function getById($id) {
        try {
            $query = "SELECT * FROM produit WHERE id = :id AND deleted = 0";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($row) {
                return new Produit(
                    $row['id'], $row['designation'], $row['prix'], 
                    $row['qtt'], $row['pathImage'], $row['deleted'], $row['idCategorie']
                );
            }
            return null;
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la récupération du produit : " . $e->getMessage());
        }
    }

    // Mettre à jour un produit
    public function update(Produit $produit) {
        try {
            $query = "UPDATE produit 
                      SET designation = :designation, prix = :prix, qtt = :qtt, 
                          deleted = :deleted, pathImage = :pathImage, idCategorie = :idCategorie 
                      WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':designation', $produit->getDesignation());
            $stmt->bindValue(':prix', $produit->getPrix());
            $stmt->bindValue(':qtt', $produit->getQtt());
            $stmt->bindValue(':deleted', $produit->getDeleted());
            $stmt->bindValue(':pathImage', $produit->getPathImage());
            $stmt->bindValue(':idCategorie', $produit->getIdCategorie());
            $stmt->bindValue(':id', $produit->getId(), PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->rowCount();
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la mise à jour du produit : " . $e->getMessage());
        }
    }

    // Supprimer un produit (suppression logique)
    public function delete($id) {
        try {
            $query = "UPDATE produit SET deleted = 1 WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->rowCount();
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la suppression du produit : " . $e->getMessage());
        }
    }

    public function getByCategory($categoryId) {
        $query = "SELECT * FROM produit WHERE idCategorie = :categoryId AND deleted = 0";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':categoryId', $categoryId, PDO::PARAM_INT);
        $stmt->execute();
        
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $products = [];
        foreach ($results as $row) {
            $products[] = new Produit(
                $row['id'], $row['designation'], $row['prix'], 
                $row['qtt'], $row['pathImage'], $row['deleted'], $row['idCategorie']
            );
        }
        return $products;
    }
    
    

    public function getTopSellingProducts(): array
{
    $query = "SELECT p.designation, SUM(cp.quantity) as total_vendus 
              FROM produit p 
              JOIN commande_produit cp ON p.id = cp.idProduit 
              GROUP BY p.id ORDER BY total_vendus DESC LIMIT 5";
    $stmt = $this->db->query($query);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Récupérer les produits supprimés
public function getDeletedProducts(): array {
    try {
        $query = "SELECT * FROM produit WHERE deleted = 1";
        $stmt = $this->db->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        throw new Exception('Erreur lors de la récupération des produits supprimés : ' . $e->getMessage());
    }
}

// Restaurer un produit supprimé
public function restore(int $id): bool {
    try {
        $stmt = $this->db->prepare('UPDATE produit SET deleted = 0 WHERE id = :id');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    } catch (PDOException $e) {
        throw new Exception('Erreur lors de la restauration du produit : ' . $e->getMessage());
    }
}


}
?>
