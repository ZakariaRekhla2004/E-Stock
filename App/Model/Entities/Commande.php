<?php

namespace App\Model\Entities;

class Commande {
    private $id;
    private $dateCommande;
    private $idUser;
    private $idClient;
    private $etat; 
    public function __construct($id, $dateCommande, $idUser, $idClient) {
        $this->id = $id;
        $this->dateCommande = $dateCommande;
        $this->idUser = $idUser;
        $this->idClient = $idClient;
    }

    public function getId() {
        return $this->id;
    }

    public function getDateCommande() {
        return $this->dateCommande;
    }

    public function getIdUser() {
        return $this->idUser;
    }

    public function getIdClient() {
        return $this->idClient;
    }
    public function getEtat() {
        return $this->etat;
    }
}
