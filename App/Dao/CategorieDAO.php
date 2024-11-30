<?php
require_once '../Config/DatabaseConnection.php';
require_once '../Model/Categorie.php';

class CategorieDAO {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    // Create a new category
    public function create(Categorie $categorie) {
        $query = "INSERT INTO categorie (nom_categorie, description, deleted) VALUES (:nom, :description, :deleted)";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':nom', $categorie->getNom());
        $stmt->bindValue(':description', $categorie->getDescription());
        $stmt->bindValue(':deleted', $categorie->getDeleted());
        $stmt->execute();
        return $this->db->lastInsertId();
    }

    // Read all categories
    public function getAll() {
        $query = "SELECT * FROM categorie";
        $stmt = $this->db->query($query);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $categories = [];
        foreach ($results as $row) {
            $categories[] = new Categorie($row['id_categorie'], $row['nom_categorie'], $row['description'], $row['deleted']);
        }
        return $categories;
    }

    // Read a category by ID
    public function getById($id) {
        $query = "SELECT * FROM categorie WHERE id_categorie = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            return new Categorie($row['id_categorie'], $row['nom_categorie'], $row['description'], $row['deleted']);
        }
        return null;
    }

    // Update a category
    public function update(Categorie $categorie) {
        $query = "UPDATE categorie SET nom_categorie = :nom, description = :description, deleted = :deleted WHERE id_categorie = :id";
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
        $query = "UPDATE categorie SET deleted = 1 WHERE id_categorie = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        return $stmt->rowCount();
    }
}
?>
