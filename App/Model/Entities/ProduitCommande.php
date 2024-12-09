<?php

namespace App\Model\Entities;

class ProduitCommande {
    private $idCommande;
    private $idProduit;
    private $quantity;

    public function __construct($idCommande, $idProduit, $quantity) {
        $this->idCommande = $idCommande;
        $this->idProduit = $idProduit;
        $this->quantity = $quantity;
    }

    public function getIdCommande() {
        return $this->idCommande;
    }

    public function getIdProduit() {
        return $this->idProduit;
    }

    public function getQuantity() {
        return $this->quantity;
    }
}
