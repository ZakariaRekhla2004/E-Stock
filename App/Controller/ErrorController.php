<?php

namespace App\Controller;

class ErrorController
{
    public function index($code)  {
        $error['code'] = $code;
        switch ($code) {
            case 403:
                $error['haedMsg'] = "Accès Non Autorisé";
                $error['detailMsg'] = "Vous n'avez pas les permissions nécessaires pour accéder à cette page.";
                break;
            
            case 404:
                $error['haedMsg'] = "Page Non Trouvée";
                $error['detailMsg'] = "La page que vous recherchez est introuvable ou a été déplacée.";
                break;
            
            default:
                // throw 
                break;
        }
        include_once './App/Views/Error/index.php';
    }
}
