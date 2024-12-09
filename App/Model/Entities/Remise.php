<?php
class Remise {
    private $id;
    private $clientId;
    private $year;
    private $totalAchats;
    private $montantRemise;

   
    public function __construct($id,$clientId, $year, $totalAchats, $montantRemise) {
        $this->id = $id;
        $this->clientId = $clientId;
        $this->year = $year;
        $this->totalAchats = $totalAchats;
        $this->montantRemise = $montantRemise;
    }
    // public function __construct($clientId, $year, $totalAchats, $montantRemise) {
        
    //     $this->clientId = $clientId;
    //     $this->year = $year;
    //     $this->totalAchats = $totalAchats;
    //     $this->montantRemise = $montantRemise;
    // }

    // Getters
    public function getId() {
        return $this->id;
    }

    public function getClientId() {
        return $this->clientId;
    }

    public function getyear() {
        return $this->year;
    }

    public function getTotalAchats() {
        return $this->totalAchats;
    }

    public function getMontantRemise() {
        return $this->montantRemise;
    }

    // Setters
    public function setId($id) {
        $this->id = $id;
    }

    public function setClientId($clientId) {
        $this->clientId = $clientId;
    }

    public function setyear($year) {
        $this->year = $year;
    }

    public function setTotalAchats($totalAchats) {
        $this->totalAchats = $totalAchats;
    }

    public function setMontantRemise($montantRemise) {
        $this->montantRemise = $montantRemise;
    }
}