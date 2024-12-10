<?php
namespace App\Config;

use App\Model\Dao\UserDao;
use App\Model\Entities\User;

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
     * Get User session
     * @return User
     */

    public static function getUser() {
    $user = isset($_SESSION['user']) ? $_SESSION['user'] : null;
    return new User( $user['email'], null, $user['nom'], $user['prenom'], null, $user['role'],$user['user_id']);
    }

    /**
     * Logout user
     */
    static function logout() {
        unset($_SESSION['user']);
    }
}
