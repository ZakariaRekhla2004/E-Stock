<?php
namespace App\Config;

use PDO;
use PDOException;
use Exception;
use Dotenv\Dotenv;

class Database
{
    private static $instance = null; // Instance unique
    private $connection; // Connexion PDO

    // Informations de connexion
    private $host; // Serveur local
    private $port; // Port MySQL personnalisé
    private $dbname; // Nom de votre base de données locale
    private $username; // Utilisateur local par défaut
    private $password; // Mot de passe (vide par défaut sur XAMPP/MAMP/WAMP)

    private function __construct()
    {
        // Directly use $_ENV or load from .env if not already loaded
        $this->host = $_ENV['DB_HOST'] ?? 'localhost';
        $this->port = $_ENV['DB_PORT'] ?? 3306;
        $this->dbname = $_ENV['DB_DATABASE'] ?? 'gestion_stock';
        $this->username = $_ENV['DB_USERNAME'] ?? 'root';
        $this->password = $_ENV['DB_PASSWORD'] ?? '';

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