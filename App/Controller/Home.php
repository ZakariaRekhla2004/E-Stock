<?php namespace App\Controller;

class Home
{
    // Return main view
    public function index() :void
    {
        include_once './App/Views/Homepage/Main.php';
    }
}