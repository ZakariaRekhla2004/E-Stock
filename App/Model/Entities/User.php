<?php
namespace App\Model\Entities;
class User {
    private $conn;
    private $table_name = 'users';

    private $id;
    private $email;
    private $password;
    private $nom;
    private $prenom;
    
    private $year_prime;
    private $role;

    public function __construct($email, $password, $nom, $prenom, $year_prime, $role, $id = null) {
        $this->id = $id;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->email = $email;
        $this->password = $password;
        $this->year_prime = $year_prime;
        $this->role = $role;
    }

    // Getters
    public function getId() {
        return $this->id;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getPassword() {
        return $this->password;
    }

    public function getNom() {
        return $this->nom;
    }

    public function getPrenom() {
        return $this->prenom;
    }

    public function getYearPrime() {
        return $this->year_prime;
    }

    public function getRole() {
        return $this->role;
    }

    // Setters
    public function setId($id) {
        $this->id = $id;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    public function setNom($nom) {
        $this->nom = $nom;
    }

    public function setPrenom($prenom) {
        $this->prenom = $prenom;
    }

    public function setYearPrime($year_prime) {
        $this->year_prime = $year_prime;
    }

    public function setRole($role) {
        $this->role = $role;
    }
}
?>
