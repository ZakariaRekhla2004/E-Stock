<?php
namespace App\Model\Entities;
class Categorie {
    private $id;
    private $nom;
    private $description;
    private $deleted;

    public function __construct($id = null, $nom = null, $description = null, $deleted = 0) {
        $this->id = $id;
        $this->nom = $nom;
        $this->description = $description;
        $this->deleted = $deleted;
    }

    public function getId() {
        return $this->id;
    }

    public function getNom() {
        return $this->nom;
    }

    public function setNom($nom) {
        $this->nom = $nom;
    }

    public function getDescription() {
        return $this->description;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function getDeleted() {
        return $this->deleted;
    }

    public function setDeleted($deleted) {
        $this->deleted = $deleted;
    }
}
?>
