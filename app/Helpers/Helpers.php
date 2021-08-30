<?php

use App\Models\App\Category;
use App\Models\App\Wallet;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
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

if (! function_exists('wallets')) {

    /**
     * @return Collection
     */
    function wallets(): Collection
    {
        return Wallet::where('user_id', auth()->id())->get();
    }
}

if (! function_exists('categories')) {

    /**
     * @param string $type
     * @return Collection
     */
    function categories(string $type): Collection
    {
        return Category::where('type', $type)->get();
    }
}

