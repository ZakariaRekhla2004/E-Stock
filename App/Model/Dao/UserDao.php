<?php
namespace App\Model\Dao;

use PDO;
use App\Config\Database;
use App\Model\Entities\User;
use PDOException;
use Exception;

class UserDao {   
    private $db;

    // this is working good
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    // this is working good
    public function getAll() {
        $query = "SELECT * FROM users";
        $stmt = $this->db->query($query);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $users = [];
        foreach ($results as $row) {
            $users[] = new User($row['email'], $row['password'], $row['nom'], $row['prenom'], $row['year_prime'], $row['role'], $row['user_id']);

        }
        return $users;
    }

    // this is working good
    public function authenticate($email, $password) {
        var_dump($this->hashPassword($password));
        try {
            // Sanitize input
            $email = htmlspecialchars(strip_tags($email));

            // Prepare query to prevent SQL injection
            $query = "SELECT * FROM users WHERE email = :email";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(":email", $email);
            $stmt->execute();

            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            // Verify password if user exists
            if ($user && $this->verifyPassword($password, $user['password'])) {
                // Remove sensitive information before returning
                unset($user['password']);
                return $user;
            }

            return null;
        } catch (PDOException $e) {
            throw new Exception('Authentication error: ' . $e->getMessage());
        }
    }

    // this is working good
    function verifyPassword($password, $dbpasword)  {
        return $this->hashPassword($password)== $dbpasword;
    }


    public function create(User $user) {
        try {
            $query = "INSERT INTO users (email, password, nom, prenom, year_prime, role) 
                      VALUES (:email, :password, :nom, :prenom, :year_prime, :role)";
            $stmt = $this->db->prepare($query);

            $hashedPassword = $this->hashPassword($user->getPassword());

            $stmt->bindValue(":email", $user->getEmail());
            $stmt->bindValue(":password", $hashedPassword);
            $stmt->bindValue(":nom", $user->getNom());
            $stmt->bindValue(":prenom", $user->getPrenom());
            $stmt->bindValue(":year_prime", $user->getYearPrime());
            $stmt->bindValue(":role", $user->getRole());

            $result = $stmt->execute();
            
            $user->setId($this->db->lastInsertId());

            return $result;
        } catch (PDOException $e) {
            throw new Exception('Error creating user: ' . $e->getMessage());
        }
    }

    // this is working good
    private function hashPassword($password) {
        // Use PHP's built-in password hashing
        return md5($password);
    }

    public function update($id, User $user) {
        try {
            $query = "UPDATE users SET 
                      email = :email, 
                      nom = :nom, 
                      prenom = :prenom, 
                      year_prime = :year_prime, 
                      role = :role 
                      WHERE user_id = :id";
            $stmt = $this->db->prepare($query);

            $stmt->bindValue(":id", $id, PDO::PARAM_INT);
            $stmt->bindValue(":email", $user->getEmail());
            $stmt->bindValue(":nom", $user->getNom());
            $stmt->bindValue(":prenom", $user->getPrenom());
            $stmt->bindValue(":year_prime", $user->getYearPrime());
            $stmt->bindValue(":role", $user->getRole());

            return $stmt->execute();
        } catch (PDOException $e) {
            throw new Exception('Error updating user: ' . $e->getMessage());
        }
    }

    public function getById($id) {
        try {
            $query = "SELECT user_id, email, nom, prenom, year_prime, role 
                      FROM users WHERE user_id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt->execute();
            
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            
            return $user ? new User(
                $user['email'], 
                null, 
                $user['nom'], 
                $user['prenom'], 
                $user['year_prime'], 
                $user['role'], 
                $user['user_id']
            ) : null;
        } catch (PDOException $e) {
            throw new Exception('Error fetching user: ' . $e->getMessage());
        }
    }

    public function delete($id) {
        try {
            $query = "DELETE FROM users WHERE user_id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);

            return $stmt->execute();
        } catch (PDOException $e) {
            throw new Exception('Error deleting user: ' . $e->getMessage());
        }
    }

    public function findByEmail($email) {
        try {
            $query = "SELECT user_id, email, nom, prenom, year_prime, role 
                      FROM users WHERE email = :email";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(":email", $email);
            $stmt->execute();
            
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            
            return $user ? new User(
                $user['email'], 
                null, 
                $user['nom'], 
                $user['prenom'], 
                $user['year_prime'], 
                $user['role'], 
                $user['user_id']
            ) : null;
        } catch (PDOException $e) {
            throw new Exception('Error finding user by email: ' . $e->getMessage());
        }
    }

    public function emailExists($email) {
        try {
            $query = "SELECT COUNT(*) FROM users WHERE email = :email";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(":email", $email);
            $stmt->execute();
            
            return $stmt->fetchColumn() > 0;
        } catch (PDOException $e) {
            throw new Exception('Error checking email existence: ' . $e->getMessage());
        }
    }

    function updateProfile($id, User $user){
        try {
            $query = "UPDATE users SET 
                      email = :email, 
                      nom = :nom, 
                      prenom = :prenom
                      WHERE user_id = :id";
            $stmt = $this->db->prepare($query);

            $stmt->bindValue(":id", $id, PDO::PARAM_INT);
            $stmt->bindValue(":email", $user->getEmail());
            $stmt->bindValue(":nom", $user->getNom());
            $stmt->bindValue(":prenom", $user->getPrenom());

            return $stmt->execute();
        } catch (PDOException $e) {
            throw new Exception('Error updating user: ' . $e->getMessage());
        }
    }

    function updatePassword($id, $password)  {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        try {
            $query = "UPDATE users SET 
            password = :password
            WHERE user_id = :id";
            $stmt = $this->db->prepare($query);

            $stmt->bindValue(":id", $id, PDO::PARAM_INT);
            $stmt->bindValue(":password", $hashedPassword);
        }catch (PDOException $e) {
            throw new Exception('Error updating user: ' . $e->getMessage());
        }
    }

}
?>