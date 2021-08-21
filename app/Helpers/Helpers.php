<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;

if (! function_exists('User')) {

    function User()
    {
        return User::find(Auth::user()->id);
    }
}
