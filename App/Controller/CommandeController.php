<?php

namespace App\Controller;

use App\Model\Dao\CommandeDAO;
use App\Model\Dao\ProduitDAO;

use App\Model\Dao\ProduitCommandeDAO;
use App\Model\Entities\Commande;
use App\Model\Entities\ProduitCommande;
use Exception;

class CommandeController {

    public function index(): void {
        $commandeDAO = new CommandeDAO();

        $view = './App/Views/CommandePage/Main.php'; // Vue principale des commandes
        include_once './App/Views/Layout/Layout.php';
    }

    public function indexListe(): void
{
    try {
        $commandeDAO = new CommandeDAO();

        // Récupérer toutes les commandes
        $commandes = $commandeDAO->getAllWithDetails();

        if (empty($commandes)) {
            $commandes = []; // Toujours retourner un tableau vide si aucune commande
        }

        // Vue principale de la liste des commandes
        $view = './App/Views/CommandePage/CommandeListe.php';
        include_once './App/Views/Layout/Layout.php'; // Layout principal
    } catch (Exception $e) {
        die("Erreur lors de la récupération des commandes : " . $e->getMessage());
    }
}


    public function add()
    {
        header('Content-Type: application/json'); // Indique que la réponse est en JSON
    
        try {
            // Récupère les données JSON envoyées par le frontend
            $data = json_decode(file_get_contents('php://input'), true);
    
            // Vérifie que les données nécessaires sont présentes
            if (!$data || !isset($data['idClient'], $data['idUser'], $data['products'])) {
                http_response_code(400); // Mauvaise requête
                echo json_encode(['error' => 'Données invalides ou incomplètes']);
                exit;
            }
    
            $idClient = $data['idClient'];
            $idUser = $data['idUser'];
            $products = $data['products'];
    
            // Instancie le DAO de commande
            $commandeDAO = new CommandeDAO();
            $produitDAO = new ProduitDAO(); // DAO pour gérer les produits
    
            // Crée une nouvelle commande et récupère l'ID de la commande
            $idCommande = $commandeDAO->create($idClient, $idUser);
    
            // Ajoute chaque produit à la commande
            foreach ($products as $product) {
                if (!isset($product['idProduit'], $product['quantity'])) {
                    http_response_code(400);
                    echo json_encode(['error' => 'Produit invalide dans la commande']);
                    exit;
                }
    
                $idProduit = $product['idProduit'];
                $quantity = $product['quantity'];
    
                // Vérifie si la quantité demandée est disponible
                $produit = $produitDAO->getById($idProduit);
                if ($produit->getQtt() < $quantity) {
                    http_response_code(400); // Mauvaise requête
                    echo json_encode(['error' => "Quantité insuffisante pour le produit ID $idProduit"]);
                    exit;
                }
    
                // Ajoute le produit à la commande
                $commandeDAO->addProductToCommande($idCommande, $idProduit, $quantity);
    
                // Diminue la quantité du produit
                $produit->setQtt($produit->getQtt() - $quantity);
                $produitDAO->update($produit);
            }
    
            // Renvoie une réponse JSON de succès
            echo json_encode(['success' => true, 'message' => 'Commande ajoutée avec succès', 'idCommande' => $idCommande]);
        } catch (Exception $e) {
            http_response_code(500); // Erreur interne du serveur
            echo json_encode(['error' => 'Erreur interne: ' . $e->getMessage()]);
        }
    }
        public function view($id): void {
        $commandeDAO = new CommandeDAO();
        $produitCommandeDAO = new ProduitCommandeDAO();

        $commande = $commandeDAO->getById($id);
        $products = $produitCommandeDAO->getByCommandeId($id);

        include_once './App/Views/Commande/Details.php';
    }

    public function imprime(): void
    {
        $id = $_GET['id'] ?? null;
    
        if (!$id) {
            die('Erreur : ID de commande manquant.');
        }
    
        $commandeDAO = new CommandeDAO();
        $commande = $commandeDAO->getById($id);
    
        if (!$commande) {
            die('Erreur : Commande introuvable.');
        }
    
        $produitCommandeDAO = new ProduitCommandeDAO();
        $produits = $produitCommandeDAO->getByCommandeId($id);
    
        include_once './App/Views/CommandePage/Imprime.php';
    }
    
}
