<?php


session_start();
require __DIR__ . '/vendor/autoload.php';

use App\Config\Router;
use App\Config\Middleware;
use App\Controller\Home;
use App\Controller\ClientController;
use App\Controller\USerController;
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


Router::post('/login', function (){
    (new LoginController())->login();
});

Router::get('/logout', function (){
    (new LoginController())->logout();
});


// Routes pour la gestion des clients
Router::get('/client', function () {
    (new ClientController())->index(); // Afficher la liste des clients
});

Router::post('/client/add', function () {
    (new ClientController())->add(); // Ajouter un client
});

Router::post('/client/edit', function () {
    (new ClientController())->update($_POST['id']);
});


Router::post('/client/delete', function () {
    $id = $_POST['id'] ?? null;
    if ($id) {
        (new ClientController())->delete($id);
    } else {
        $_SESSION['error_message'] = 'Aucun ID fourni pour la suppression.';
        header('Location: /client');
        exit;
    }
});

// Routes pour la gestion des catégories
Router::get('/category', function () {
    (new CategorieController())->index(); // Afficher la liste des catégories
});

Router::post('/category/add', function () {
    (new CategorieController())->add(); // Ajouter une catégorie
});

Router::post('/category/edit', function () {
    $id = $_POST['id'] ?? null;
    if ($id) {
        (new CategorieController())->update($id); // Modifier une catégorie
    } else {
        $_SESSION['error_message'] = 'Aucun ID fourni pour la modification.';
        header('Location: /category');
        exit;
    }
});

Router::post('/category/delete', function () {
    $id = $_POST['id'] ?? null;
    if ($id) {
        (new CategorieController())->delete($id); // Supprimer une catégorie
    } else {
        $_SESSION['error_message'] = 'Aucun ID fourni pour la suppression.';
        header('Location: /category');
        exit;
    }
});

// Routes pour la gestion des users
Router::get('/user', function () {
    (new UserController())->index(); // Afficher la liste des Users
});

Router::post('/user/add', function () {
    (new UserController())->add(); // Ajouter un user
});

Router::post('/user/edit', function () {
    (new UserController())->update($_POST['id']);
});


Router::post('/user/delete', function () {
    $id = $_POST['id'] ?? null;
    if ($id) {
        (new UserController())->delete($id);
    } else {
        $_SESSION['error_message'] = 'Aucun ID fourni pour la suppression.';
        header('Location: /user');
        exit;
    }
});

// Routes pour la gestion du profile
Router::get('/my-profile', function () {
    (new UserController())->profile();
});

Router::post('/my-profile/update', function () {
    (new UserController())->updateprofile();
});

?>
