<?php

namespace App\Controller;

use App\Config\Auth;

class LoginController
{
    /**
     * Affiche le formulaire de connexion.
     */
    public function index(): void
    {
        // Chemin vers la vue de connexion
        $view = './App/Views/Login/Login.php';
        
        // Inclusion du layout principal
        include_once './App/Views/Layout/LoginLayout.php';
    }

    public function login()  {

        if (!isset($_POST['email']) || !isset($_POST['password'])) {
            $_SESSION['error_message'] = 'Remplire tous les champs';
            header("Location: /login");
            exit;
        }

        if(Auth::authenticate($_POST['email'] ,$_POST['password'])){
            header("Location: /");
            exit;
        }else{
            $_SESSION['error_message'] = 'Les identifiants sont incorrects. Veuillez réessayer.';            header("Location: /login");
            exit;
        }
        
    }

    function logout()  {
        Auth::logout();
        header("Location: /login");
        exit;
    }
}
