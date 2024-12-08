<?php
// require_once '../Config/DatabaseConnection.php';
// require_once '../Model/Produit.php';
namespace App\Model\Dao;

class ProduitDAO {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    // Create a new product
    public function create(Produit $produit) {
        // Check if the category exists and is not deleted
        $categoryCheckQuery = "SELECT COUNT(*) FROM categorie WHERE id_categorie = :id_categorie AND deleted = 0";
        $categoryCheckStmt = $this->db->prepare($categoryCheckQuery);
        $categoryCheckStmt->bindValue(':id_categorie', $produit->getIdCategorie(), PDO::PARAM_INT);
        $categoryCheckStmt->execute();
        $categoryExists = $categoryCheckStmt->fetchColumn();
    
        if ($categoryExists == 0) {
            throw new Exception("Cannot add product. The associated category is deleted or does not exist.");
        }
    
        // Proceed to insert the product
        $query = "INSERT INTO produit (designation, prix, qtt, deleted, id_categorie) 
                  VALUES (:designation, :prix, :qtt, :deleted, :id_categorie)";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':designation', $produit->getDesignation());
        $stmt->bindValue(':prix', $produit->getPrix());
        $stmt->bindValue(':qtt', $produit->getQtt());
        $stmt->bindValue(':deleted', $produit->getDeleted());
        $stmt->bindValue(':id_categorie', $produit->getIdCategorie(), PDO::PARAM_INT);
        $stmt->execute();
        return $this->db->lastInsertId();
    }    

    // Read all products
    public function getAll() {
        $query = "SELECT * FROM produit";
        $stmt = $this->db->query($query);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $products = [];
        foreach ($results as $row) {
            $products[] = new Produit(
                $row['id_produit'], $row['designation'], $row['prix'], 
                $row['qtt'], $row['deleted'], $row['id_categorie']
            );
        }
        return $products;
    }

    // Read a product by ID
    public function getById($id) {
        $query = "SELECT * FROM produit WHERE id_produit = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            return new Produit(
                $row['id_produit'], $row['designation'], $row['prix'], 
                $row['qtt'], $row['deleted'], $row['id_categorie']
            );
        }
        return null;
    }

    // Update a product
    public function update(Produit $produit) {
        $query = "UPDATE produit SET designation = :designation, prix = :prix, qtt = :qtt, 
                  deleted = :deleted, id_categorie = :id_categorie WHERE id_produit = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':designation', $produit->getDesignation());
        $stmt->bindValue(':prix', $produit->getPrix());
        $stmt->bindValue(':qtt', $produit->getQtt());
        $stmt->bindValue(':deleted', $produit->getDeleted());
        $stmt->bindValue(':id_categorie', $produit->getIdCategorie());
        $stmt->bindValue(':id', $produit->getId());
        $stmt->execute();
        return $stmt->rowCount();
    }

    // Delete a product
    public function delete($id) {
        $query = "UPDATE produit SET deleted = 1 WHERE id_produit = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->rowCount();
    }    
}
?>
