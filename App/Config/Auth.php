<?php
namespace App\Config;

use App\Model\Dao\UserDao;

class Auth
{

    static function authenticate($username, $password) {
        $userDao = new UserDao();
        $user = $userDao->authenticate($username, $password);
        if ($user != null) {
            $_SESSION['user'] = $user;
            return true;
        }
        return false;
    }


    static function isAuthenticated()
    {
        // Implement your authentication logic
        // Example:
        return isset($_SESSION['user']);
    }

    /**
     * Check if user has required role
     * @param array $allowedRoles
     * @return bool
     */
    public static function hasRole(array $allowedRoles)
    {
        // Implement your role checking logic
        // Example:
        return isset($_SESSION['user']['role']) && 
               in_array($_SESSION['user']['role'], $allowedRoles);
    }

    /**
     * Logout user
     */
    static function logout() {
        unset($_SESSION['user']);
    }
}
