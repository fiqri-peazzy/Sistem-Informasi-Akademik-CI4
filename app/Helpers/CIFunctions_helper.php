<?php

use App\Libraries\CiAuth;
use App\Models\User;

use CodeIgniter\Router\RouteCollection;

if (!function_exists('current_route_name')) {
    function current_route_name()
    {
        $router = service('router');
        return $router->getMatchedRoute()[0] ?? null;
    }
}

if (!function_exists('get_user')) {
    function get_user()
    {
        if (CiAuth::check()) {
            $user  = new User();
            return $user->asObject()->where('id', CIauth::id())->first();
        } else {
            return null;
        }
    }
}