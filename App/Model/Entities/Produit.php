<?php
namespace App\Model\Entities;
class Produit {
    private $id;
    private $designation;
    private $prix;
    private $qtt;
    private $deleted;
    private $pathImage;
    private $idCategorie;

    public function __construct($id = null, $designation = null, $prix = 0, $qtt = 0,$pathImage = null, $deleted = 0, $idCategorie = null) {
        $this->id = $id;
        $this->designation = $designation;
        $this->prix = $prix;
        $this->qtt = $qtt;
        $this->pathImage = $pathImage;
        $this->deleted = $deleted;
        $this->idCategorie = $idCategorie;
    }

    public function getId() {
        return $this->id;
    }

    public function getDesignation() {
        return $this->designation;
    }

    public function setDesignation($designation) {
        $this->designation = $designation;
    }

    public function getPrix() {
        return $this->prix;
    }

    public function setPrix($prix) {
        $this->prix = $prix;
    }

    public function getQtt() {
        return $this->qtt;
    }

    public function setQtt($qtt) {
        $this->qtt = $qtt;
    }

    public function getDeleted() {
        return $this->deleted;
    }

    public function setDeleted($deleted) {
        $this->deleted = $deleted;
    }

    public function getIdCategorie() {
        return $this->idCategorie;
    }

    public function setIdCategorie($idCategorie) {
        $this->idCategorie = $idCategorie;
    }
    
    public function getPathImage() {
        return $this->pathImage;
    }
    public function setPathImage($pathImage) {
        $this->pathImage = $pathImage;
    }
}
?>
