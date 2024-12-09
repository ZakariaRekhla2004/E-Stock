<?php

namespace App\Controller;

class RemiseController
{
    public function index(): void
    {
        $view = './App/Views/PrimesRemisePage/Remise.php'; // Main view
        include_once './App/Views/Layout/Layout.php'; // Layout with the main view
    }

}