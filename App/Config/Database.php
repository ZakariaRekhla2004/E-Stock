<?php
namespace App\Config;

use PDO;
use PDOException;
use Exception;

class Database
{
    private static $instance = null; // Instance unique
    private $connection; // Connexion PDO

    // Informations de connexion
    private $host = "localhost"; // Serveur local
    private $port = "3308"; // Port MySQL personnalisé
    private $dbname = "gestion_stock"; // Nom de votre base de données locale
    private $username = "root"; // Utilisateur local par défaut
    private $password = ""; // Mot de passe (vide par défaut sur XAMPP/MAMP/WAMP)

    private function __construct()
    {
        try {
            $this->connection = new PDO(
                "mysql:host={$this->host};port={$this->port};dbname={$this->dbname};charset=utf8",
                $this->username,
                $this->password
            );
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Erreur de connexion à la base de données : " . $e->getMessage());
        }
    }

    // Méthode pour récupérer l'instance unique
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    // Méthode pour récupérer la connexion PDO
    public function getConnection()
    {
        return $this->connection;
    }

    // Empêcher la copie de l'instance
    private function __clone()
    {
    }

    // Empêcher la désérialisation
    public function __wakeup()
    {
    }
}

// Pour tester la classe

try {
    $db = Database::getInstance()->getConnection();
} catch (Exception $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>