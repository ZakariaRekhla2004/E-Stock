<?php 
namespace App\Model\Entities;  

class Prime {     
    private $id;     
    private $idCommercial;     
    private $chiffreAffaire;  
    private $prime;     
    private $year;      
    private $commercialName;
    
    
    
    
    public function __construct($id = null, $idCommercial, $chiffreAffaire, $prime, $year) {         
        $this->id = $id;         
        $this->idCommercial = $idCommercial;         
        $this->chiffreAffaire = $chiffreAffaire;  
        $this->prime = $prime;         
        $this->year = $year;     
    }      

    public function setCommercialName($name) {
        $this->commercialName = $name;
    }

    public function getCommercialName() {
        return $this->commercialName;
    }
    public function getId() {         
        return $this->id;     
    }      

    public function getIdCommercial() {         
        return $this->idCommercial;     
    }      

    public function getChiffreAffaire() {  // Changed from getChiffreAffaireTotal
        return $this->chiffreAffaire;     
    }      

    public function getPrime() {         
        return $this->prime;     
    }      

    public function getYear() {         
        return $this->year;     
    } 
}