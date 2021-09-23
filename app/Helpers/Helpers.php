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

if (! function_exists('filterValidate')) {

    /**
     * @param string $filter
     * @param $value
     * @return bool
     */
    function filterValidate(string $filter, $value): bool
    {
        switch ($filter) {
            case 'status':
                return $value == 'all' || $value == 'paid' || $value == 'unpaid';

            case 'category':
                return $value == 'all' || !empty(Category::findById($value));

            case 'date':
                if($value == 'all') {
                    return true;
                }   elseif(count(explode('-', $value)) == 2) {
                    list($m, $y) = explode('-', $value);

                    return (is_numeric($m) && 0 < $m && $m < 13) && (is_numeric($y));
                }
        }

        return false;
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

if (! function_exists('walletactive')) {

    /**
     * @return Wallet
     */
    function walletactive(): Wallet
    {
        if(session()->has('walletfilter')) {
            return Wallet::findById(session()->get('walletfilter'));
        } else {
            return Wallet::free();
        }
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

if (! function_exists('str_price')) {

    /**
     * @param string|null $price
     * @return string
     */
    function str_price(?string $price): string
    {
        return number_format((!empty($price) ? $price : 0), 2, ",", ".");
    }
}

if(! function_exists('setNonSingleValidate')) {

    /**
     * Sets the non single invoices as validated in the session
     */
    function setNonSingleAsValidated() {
        session()->put('nonSingleInvoicesValidated', true);
    }
}





