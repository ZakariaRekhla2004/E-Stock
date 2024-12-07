<?php
session_start();
require __DIR__ . '/vendor/autoload.php';

use App\Config\Router;
use App\Controller\Home;
use App\Controller\ClientController;

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


?>
