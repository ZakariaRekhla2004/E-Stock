<?php

use App\Controller\ProduitController;


session_start();
require __DIR__ . '/vendor/autoload.php';

use App\Config\Router;
use App\Controller\Home;
use App\Controller\ClientController;
use App\Controller\CommandeController;
use App\Controller\CategorieController;
use App\Controller\LoginController;

// Routes existantes
Router::get('/', function () {
   (new Home())->index();
});

Router::get('/about', function (){
    (new Home())->aboutView();
});

Router::get('/contact', function (){
    (new Home())->contactForm();
});

Router::get('/login', function (){
    (new LoginController())->index();
});

// Routes pour la gestion des clients
Router::get('/Client', function () {
    (new ClientController())->index(); // Afficher la liste des clients
});

Router::post('/Client/add', function () {
    (new ClientController())->add(); // Ajouter un client
});

Router::post('/Client/edit', function () {
    (new ClientController())->update($_POST['id']);
});


Router::post('/Client/delete', function () {
    $id = $_POST['id'] ?? null;
    if ($id) {
        (new ClientController())->delete($id);
    } else {
        $_SESSION['error_message'] = 'Aucun ID fourni pour la suppression.';
        header('Location: /Client');
        exit;
    }
});

Router::get('/Commande', function () {
    (new CommandeController())->index();
 });
 
// Routes pour la gestion des catégories
Router::get('/Category', function () {
    (new CategorieController())->index(); // Afficher la liste des catégories
});

Router::post('/Category/add', function () {
    (new CategorieController())->add(); // Ajouter une catégorie
});

Router::post('/Category/edit', function () {
    $id = $_POST['id'] ?? null;
    if ($id) {
        (new CategorieController())->update($id); // Modifier une catégorie
    } else {
        $_SESSION['error_message'] = 'Aucun ID fourni pour la modification.';
        header('Location: /Category');
        exit;
    }
});

Router::post('/Category/delete', function () {
    $id = $_POST['id'] ?? null;
    if ($id) {
        (new CategorieController())->delete($id); // Supprimer une catégorie
    } else {
        $_SESSION['error_message'] = 'Aucun ID fourni pour la suppression.';
        header('Location: /Category');
        exit;
    }
});


// Routes pour la gestion des produits
Router::get('/Product', function () {
    (new ProduitController())->index(); // Afficher la liste des produits
});

Router::post('/Product/add', function () {
    (new ProduitController())->add(); // Ajouter un produit
});

Router::post('/Product/edit', function () {
    $id = $_POST['id'] ?? null;
    if ($id) {
        (new ProduitController())->update($id); // Modifier un produit
    } else {
        $_SESSION['error_message'] = 'Aucun ID fourni pour la modification.';
        header('Location: /Product');
        exit;
    }
});

Router::post('/Product/delete', function () {
    $id = $_POST['id'] ?? null;
    if ($id) {
        (new ProduitController())->delete($id); // Supprimer un produit
    } else {
        $_SESSION['error_message'] = 'Aucun ID fourni pour la suppression.';
        header('Location: /Product');
        exit;
    }
});



?>
