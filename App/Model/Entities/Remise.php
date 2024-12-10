<?php
namespace App\Model\Entities;  

class Remise {
    private $id;
    private $id_client;
    private $annee;
    private $total_achats;
    private $remise;
    private $client_name;

    public function __construct($id, $id_client, $annee, $total_achats, $remise) {
        $this->id = $id;
        $this->id_client = $id_client;
        $this->annee = $annee;
        $this->total_achats = $total_achats;
        $this->remise = $remise;
    }

    // Getters
    public function getId() {
        return $this->id;
    }

    public function getClientName() {
        return $this->client_name;
    }

    public function setClientName($client_name) {
        $this->client_name = $client_name;
    }

    public function getIdClient() {
        return $this->id_client;
    }

    public function getAnnee() {
        return $this->annee;
    }

    public function getTotalAchats() {
        return $this->total_achats;
    }

    public function getRemise() {
        return $this->remise;
    }

    // Setters
    public function setId($id) {
        $this->id = $id;
    }

    public function setClientId($clientId) {
        $this->id_client = $clientId;
    }

    public function setAnnee($annee) {
        $this->annee = $annee;
    }

    public function setTotalAchats($totalAchats) {
        $this->total_achats = $totalAchats;
    }

    public function setMontantRemise($montantRemise) {
        $this->remise = $montantRemise;
    }
}
