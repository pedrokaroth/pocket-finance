<?php

use App\Http\Controllers\App\AppController;
use App\Http\Controllers\App\InvoiceController;
use App\Http\Controllers\App\WalletController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['verify' => true]);

Route::group(['middleware' => ['auth', 'verified', 'wallet'], 'prefix' => 'app', 'as' => 'app.'], function() {
    Route::get('/', [
      AppController::class, 'home'
    ])->name('home');

    Route::resource('wallets', WalletController::class);
    Route::post('/wallets/filter/{id}', [WalletController::class, 'walletFilter'])->name('wallets.filter');
    Route::get('/carteiras', [AppController::class, 'wallets'])->name('wallets');
    Route::group(['prefix' => 'faturas'], function() {
       Route::get('despesas', [AppController::class, 'expenses'])->name('expenses');
       Route::get('receitas', [AppController::class, 'incomes'])->name('incomes');
    });

    Route::resource('invoices', InvoiceController::class);
});
