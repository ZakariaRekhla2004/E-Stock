<?php
namespace App\Model\Dao;

use PDO;
use App\Config\Database;
use App\Model\Entities\Categorie;
use PDOException; 
use Exception;

class CategorieDAO {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    // Create a new category
    public function create(Categorie $categorie) {
        $query = "INSERT INTO categorie (nom, description, deleted) VALUES (:nom, :description, :deleted)";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':nom', $categorie->getNom());
        $stmt->bindValue(':description', $categorie->getDescription());
        $stmt->bindValue(':deleted', $categorie->getDeleted());
        $stmt->execute();
        return $this->db->lastInsertId();
    }

    // Read all categories
    public function getAll() {
        $query = "SELECT * FROM categorie WHERE deleted = 0";
        $stmt = $this->db->query($query);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $categories = [];
        foreach ($results as $row) {
            $categories[] = new Categorie($row['id'], $row['nom'], $row['description'], $row['deleted']);
        }
        return $categories;
    }

    public function getAllForPanel() {
        try {
            $query = "SELECT * FROM categorie WHERE deleted = 0";
            $stmt = $this->db->query($query);
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            // Debugging
            if (empty($results)) {
                error_log("Aucune catégorie trouvée.");
            }
    
            return $results; // Retourne directement le tableau associatif
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la récupération des catégories : " . $e->getMessage());
        }
    }
    

    // Read a category by ID
    public function getById($id) {
        $query = "SELECT * FROM categorie WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            return new Categorie($row['id'], $row['nom'], $row['description'], $row['deleted']);
        }
        return null;
    }

    // Update a category
    public function update(Categorie $categorie) {
        $query = "UPDATE categorie SET nom = :nom, description = :description, deleted = :deleted WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':nom', $categorie->getNom());
        $stmt->bindValue(':description', $categorie->getDescription());
        $stmt->bindValue(':deleted', $categorie->getDeleted());
        $stmt->bindValue(':id', $categorie->getId());
        $stmt->execute();
        return $stmt->rowCount();
    }

    // Delete a category (soft delete)
    public function delete($id) {
        $query = "UPDATE categorie SET deleted = 1 WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        return $stmt->rowCount();
    }
    public function getCategoryById($id) {
        $query = "SELECT nom FROM categorie WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        // Retourner le nom de la catégorie si trouvée
        $category = $stmt->fetch(PDO::FETCH_ASSOC);
        return $category ? $category['nom'] : null; // Renvoie le nom ou null si non trouvé
    }
    public function getProductsByCategory(): array
    {
        $query = "SELECT c.nom, COUNT(p.id) as total 
                  FROM categorie c 
                  LEFT JOIN produit p ON c.id = p.idCategorie 
                  WHERE p.deleted = 0 
                  GROUP BY c.id";
        $stmt = $this->db->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Récupérer les catégories supprimées (soft-deleted)
public function getDeletedCategories(): array {
    try {
        $query = "SELECT * FROM categorie WHERE deleted = 1";
        $stmt = $this->db->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        throw new Exception('Erreur lors de la récupération des catégories supprimées : ' . $e->getMessage());
    }
}

// Restaurer une catégorie supprimée
public function restore($id): bool {
    try {
        $query = "UPDATE categorie SET deleted = 0 WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        return $stmt->execute();
    } catch (PDOException $e) {
        throw new Exception('Erreur lors de la restauration de la catégorie : ' . $e->getMessage());
    }
}

}
?>
