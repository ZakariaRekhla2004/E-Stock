<?php

use App\Config\Auth;
use App\Controller\ErrorController;
use App\Model\Enums\UserRoles;







session_start();
require __DIR__ . '/vendor/autoload.php';

use App\Config\Router;
use App\Config\Middleware;
use App\Controller\Home;
use App\Controller\ClientController;
use App\Controller\USerController;
use App\Controller\CommandeController;
use App\Controller\CategorieController;
use App\Controller\LoginController;
use App\Controller\PrimeController;
use App\Model\Dao\ProduitCommandeDAO;
use App\Controller\ProduitController;
use App\Controller\DashboardController;
use App\Controller\RemiseController;
// use App\Model\Enums\UserRoles;


Router::get('/login', function () {
    (new LoginController())->index();
});


Router::post('/login', function () {
    (new LoginController())->login();
});

Router::get('/logout', function () {
    Middleware::authenticated();
    (new LoginController())->logout();
});


// Routes pour la gestion des clients
Router::get('/Client', function () {
    Middleware::role([
        UserRoles::ADMIN->value,
        UserRoles::COMERCIAL->value,
        UserRoles::DIRECTION->value
    ]);
    (new ClientController())->index(); // Afficher la liste des clients
});

Router::post('/Client/add', function () {
    Middleware::role([
        UserRoles::ADMIN->value,
        UserRoles::COMERCIAL->value
    ]);
    (new ClientController())->add(); // Ajouter un client
});

Router::post('/Client/edit', function () {
    Middleware::role([
        UserRoles::ADMIN->value,
        UserRoles::COMERCIAL->value
    ]);
    (new ClientController())->update($_POST['id']);
});


Router::post('/Client/delete', function () {
    Middleware::role([
        UserRoles::ADMIN->value,
        UserRoles::COMERCIAL->value
    ]);
    $id = $_POST['id'] ?? null;
    if ($id) {
        (new ClientController())->delete($id);
    } else {
        $_SESSION['error_message'] = 'Aucun ID fourni pour la suppression.';
        header('Location: /client');
        exit;
    }
});

Router::get('/Commande', function () {
    Middleware::role([
        UserRoles::COMERCIAL->value
    ]);
    (new CommandeController())->index();
});

// Routes pour la gestion des catégories
Router::get('/Category', function () {
    Middleware::role([
        UserRoles::ADMIN->value,
        UserRoles::ACHAT->value,
        UserRoles::DIRECTION->value
    ]);
    (new CategorieController())->index(); // Afficher la liste des catégories
});

Router::post('/Category/add', function () {
    Middleware::role([
        UserRoles::ADMIN->value,
        UserRoles::ACHAT->value
    ]);
    (new CategorieController())->add(); // Ajouter une catégorie
});

Router::post('/Category/edit', function () {
    Middleware::role([
        UserRoles::ADMIN->value,
        UserRoles::ACHAT->value
    ]);
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
    Middleware::role([
        UserRoles::ADMIN->value,
        UserRoles::ACHAT->value
    ]);
    $id = $_POST['id'] ?? null;
    if ($id) {
        (new CategorieController())->delete($id); // Supprimer une catégorie
    } else {
        $_SESSION['error_message'] = 'Aucun ID fourni pour la suppression.';
        header('Location: /Category');
        exit;
    }
});

// Routes pour la gestion des users
Router::get('/user', function () {
    Middleware::role([
        UserRoles::ADMIN->value,
        UserRoles::RH->value,
        UserRoles::DIRECTION->value
    ]);
    (new UserController())->index(); // Afficher la liste des Users
});

Router::post('/user/add', function () {
    Middleware::role([
        UserRoles::ADMIN->value,
        UserRoles::RH->value
    ]);
    (new UserController())->add(); // Ajouter un user
});

Router::post('/user/edit', function () {
    Middleware::role([
        UserRoles::ADMIN->value,
        UserRoles::RH->value
    ]);
    (new UserController())->update($_POST['id']);
});


Router::post('/user/delete', function () {
    Middleware::role([
        UserRoles::ADMIN->value,
        UserRoles::RH->value
    ]);
    $id = $_POST['id'] ?? null;
    if ($id) {
        (new UserController())->delete($id);
    } else {
        $_SESSION['error_message'] = 'Aucun ID fourni pour la suppression.';
        header('Location: /user');
    }
});

// Routes pour la gestion des produits
Router::get('/Product', function () {
    Middleware::role([
        UserRoles::ADMIN->value,
        UserRoles::ACHAT->value,
        UserRoles::DIRECTION->value
    ]);
    (new ProduitController())->index(); // Afficher la liste des produits
});

Router::post('/Product/add', function () {
    
    Middleware::role([
        UserRoles::ADMIN->value,
        UserRoles::ACHAT->value
    ]);
    (new ProduitController())->add(); // Ajouter un produit
});

Router::post('/Product/edit', function () {
    
    Middleware::role([
        UserRoles::ADMIN->value,
        UserRoles::ACHAT->value
    ]);
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
    
    Middleware::role([
        UserRoles::ADMIN->value,
        UserRoles::ACHAT->value
    ]);
    $id = $_POST['id'] ?? null;
    if ($id) {
        (new ProduitController())->delete($id); // Supprimer un produit
    } else {
        $_SESSION['error_message'] = 'Aucun ID fourni pour la suppression.';
        header('Location: /Product');
        exit;
    }
});

// Routes pour la gestion du profile
Router::get('/my-profile', function () {
    Middleware::authenticated();
    (new UserController())->profile();
});

Router::post('/my-profile/update', function () {
    Middleware::authenticated();
    (new UserController())->updateprofile();
});


////////////////////////////////     Remise // Prime //////////////////////////////////
Router::get('/remise', function () {
    Middleware::authenticated();
    (new RemiseController())->index();
});

Router::get('/prime', function () {
    Middleware::authenticated();
    (new PrimeController())->index();
});

Router::post('/Commande/add', function () {
    Middleware::role([
        UserRoles::ADMIN->value,
        UserRoles::COMERCIAL->value
    ]);
    (new CommandeController())->add();
});

Router::get('/Commande', function ($id) {
    Middleware::role([
        UserRoles::ADMIN->value,
        UserRoles::COMERCIAL->value,
        UserRoles::DIRECTION->value,
    ]);
    (new CommandeController())->index();
});


Router::get('/categoriesPanier', function () {  
    Middleware::role([
        UserRoles::ADMIN->value,
        UserRoles::COMERCIAL->value
    ]);
    $categorieDAO = new App\Model\Dao\CategorieDAO();
    $categories = $categorieDAO->getAllForPanel();
    header('Content-Type: application/json');
    echo json_encode($categories);
    exit;
});


Router::get('/productsPanier', function () {
    Middleware::role([
        UserRoles::ADMIN->value,
        UserRoles::COMERCIAL->value
    ]);
    $produitDAO = new App\Model\Dao\ProduitDAO();
    $products = $produitDAO->getAllForPannel();
    header('Content-Type: application/json');
    echo json_encode($products);
    exit;
});

Router::get('/clientPanier', function () {
    Middleware::role([
        UserRoles::ADMIN->value,
        UserRoles::COMERCIAL->value
    ]);
    $clientDAO = new App\Model\Dao\ClientDAO();
    $clients = $clientDAO->getAllForPanel();
    header('Content-Type: application/json');
    echo json_encode($clients);
    exit;
});

Router::get('/CommandeListe', function () {
    Middleware::role([
        UserRoles::ADMIN->value,
        UserRoles::COMERCIAL->value,
        UserRoles::DIRECTION->value
    ]);
    (new CommandeController())->indexListe();
});
Router::get('/Commande/produits', function () {
    Middleware::role([
        UserRoles::ADMIN->value,
        UserRoles::COMERCIAL->value,
        UserRoles::DIRECTION->value
    ]);
    $id = $_GET['id'] ?? null;
    if ($id) {
        $produitCommandeDAO = new ProduitCommandeDAO();
        $produits = $produitCommandeDAO->getByCommandeId($id);
        header('Content-Type: application/json');
        echo json_encode($produits);
        exit;
    } else {
        http_response_code(400);
        echo json_encode(['error' => 'ID commande manquant']);
    }
});

Router::get('/Commande/imprime', function () {
    Middleware::role([
        UserRoles::ADMIN->value,
        UserRoles::COMERCIAL->value,
        UserRoles::DIRECTION->value
    ]);
    (new CommandeController())->imprime();
});

Router::get('/', function () {
    if (Auth::isAuthenticated()) (new DashboardController())->index();
    else (new Home())->index();
});

/**
 * Error Routes
 */
Router::get('/unauthorized', function () {
    (new ErrorController())->index(code: 403);
});
Router::get('/pagenotfound', function () {
    (new ErrorController())->index(code: 404);
});
// Handle unmatched routes
Router::handleNotFound('/pagenotfound');

?>