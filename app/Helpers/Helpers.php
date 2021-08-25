<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

if (! function_exists('isActive')) {

    /**
     * @param string $route
     * @param string $class
     * @return string
     */
    function isActive(string $route, string $class = "active"): string
    {
        return Route::currentRouteName() === $route ?
            $class : "";

    }
}
