<?php

namespace App\Controller;

class PrimeController
{
    public function index(): void
    {
        $view = './App/Views/PrimesRemisePage/Prime.php'; // Main view
        include_once './App/Views/Layout/Layout.php'; // Layout with the main view
    }

}
