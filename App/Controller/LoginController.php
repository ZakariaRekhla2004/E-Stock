<?php

namespace App\Controller;

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
}
