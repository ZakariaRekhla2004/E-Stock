<?php
require_once '../Dao/CategorieDAO.php';

class CategorieController {
    private $categorieDAO;

    public function __construct() {
        $this->categorieDAO = new CategorieDAO();
    }

    // Create category
    public function create($nom, $description) {
        $categorie = new Categorie(null, $nom, $description);
        return $this->categorieDAO->create($categorie);
    }

    // Get all categories
    public function getAll() {
        return $this->categorieDAO->getAll();
    }

    // Get category by ID
    public function getById($id) {
        return $this->categorieDAO->getById($id);
    }

    // Update category
    public function update($id, $nom, $description, $deleted = 0) {
        $categorie = new Categorie($id, $nom, $description, $deleted);
        return $this->categorieDAO->update($categorie);
    }

    // Delete category (soft delete)
    public function delete($id) {
        return $this->categorieDAO->delete($id);
    }
}
?>
