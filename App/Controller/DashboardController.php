<?php

namespace App\Controller;

use App\Model\Dao\CategorieDAO;
use App\Model\Dao\ClientDAO;
use App\Model\Dao\CommandeDAO;
use App\Model\Dao\ProduitDAO;
use App\Model\Dao\UserDAO;


class DashboardController
{
    public function index(): void
    {
        $categorieDAO = new CategorieDAO();
        $clientDAO = new ClientDAO();
        $commandeDAO = new CommandeDAO();
        $produitDAO = new ProduitDAO();
        $userDAO = new UserDAO(); // Ajouter l'initialisation du DAO utilisateur
    
        // Statistiques clés
        $nombreCategories = count($categorieDAO->getAll());
        $nombreClients = count($clientDAO->getAll());
        $nombreCommandes = $commandeDAO->getTotalOrders();
        $revenusTotaux = $commandeDAO->getTotalRevenue();
    
        // Données supplémentaires
        $clientsActifs = $clientDAO->getTopClients();
        $produitsPopulaires = $produitDAO->getTopSellingProducts();
        $produitsParCategorie = $categorieDAO->getProductsByCategory();
        $ventesParMois = $commandeDAO->getMonthlySales();
        $utilisateursActifs = $userDAO->getMostActiveUsers(); // Ajouter cette ligne
    
        // Inclure la vue
        $view = './App/Views/Dashboard/main.php';
        include_once './App/Views/Layout/Layout.php';
    }
    
}
