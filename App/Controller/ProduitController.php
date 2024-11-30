<?php
require_once '../Dao/ProduitDAO.php';

class ProduitController {
    private $produitDAO;

    public function __construct() {
        $this->produitDAO = new ProduitDAO();
    }

    // Create product
    public function create($designation, $prix, $qtt, $idCategorie) {
        $produit = new Produit(null, $designation, $prix, $qtt, 0, $idCategorie);
        return $this->produitDAO->create($produit);
    }

    // Get all products
    public function getAll() {
        return $this->produitDAO->getAll();
    }

    // Get product by ID
    public function getById($id) {
        return $this->produitDAO->getById($id);
    }

    // Update product
    public function update($id, $designation, $prix, $qtt, $idCategorie) {
        $produit = new Produit($id, $designation, $prix, $qtt, 0, $idCategorie);
        return $this->produitDAO->update($produit);
    }

    // Delete product
    public function delete($id) {
        return $this->produitDAO->delete($id);
    }
}
?>
