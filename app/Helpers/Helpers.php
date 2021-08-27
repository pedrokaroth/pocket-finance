<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

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

if (! function_exists('user')) {

    /**
     * @return User
     */
    function user(): User
    {
        return User::find(Auth::id());
    }
}

if (! function_exists('message')) {

    /**
     * @return string
     */
    function message(): string
    {
        if(Session::has('message')) {
            $message = Session::get('message');

            return "data-type='{$message['type']}' data-message='{$message['message']}'";
        }

        return '';
    }
}
