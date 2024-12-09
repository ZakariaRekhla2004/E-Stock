<?php
namespace App\Model\Entities;

class Prime {
    private $id;
    private $idCommercial;
    private $chiffreAffaireTotal;
    private $prime;
    private $year;

    public function __construct($id = null, $idCommercial, $chiffreAffaireTotal,$prime, $year) {
        $this->id = $id;
        $this->idCommercial = $idCommercial;
        $this->chiffreAffaireTotal = $chiffreAffaireTotal;
        $this->prime = 0;
        $this->year = $year;
    }

    private function calculerPrime() {
        return $this->chiffreAffaireTotal * 0.10; // 10% du CA total
    }

    public function getId() {
        return $this->id;
    }

    public function getIdCommercial() {
        return $this->idCommercial;
    }

    public function getChiffreAffaireTotal() {
        return $this->chiffreAffaireTotal;
    }

    public function getPrime() {
        return $this->prime;
    }

    public function getYear() {
        return $this->year;
    }
}
