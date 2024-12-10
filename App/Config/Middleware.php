<?php
namespace App\Config;

use Closure;

class Middleware
{
    private static $middlewares = [];

    /**
     * Authenticate routes
     * @param Closure $routes
     * @return void
     */
    public static function authenticated()
    {
        // Implement your authentication check
        if (!Auth::isAuthenticated()) {
            header('Location: /login');
            exit;
        }
    }

    /**
     * Role-based route protection
     * @param string|array $allowedRoles
     * @param Closure $routes
     * @return void
     */
    public static function role($allowedRoles)
    {
        // Normalize roles to array
        $allowedRoles = is_string($allowedRoles) ? [$allowedRoles] : $allowedRoles;

        // Check authentication first
        if (!Auth::isAuthenticated()) {
            header('Location: /login');
            exit;
        }

        // Check user role
        if (Auth::hasRole($allowedRoles)) {
            header('Location: /unauthorized');
            exit;
        }
    }
}