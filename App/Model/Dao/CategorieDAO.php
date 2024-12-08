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
}
?>
