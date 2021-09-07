<?php

use App\Http\Controllers\App\AppController;
use App\Http\Controllers\App\InvoicesController;
use App\Http\Controllers\App\WalletsController;
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
    Route::get('/', [AppController::class, 'home'])->name('home');
    /*
     *  WALLETS
     */
    Route::resource('wallets', WalletsController::class);
    Route::post('/wallets/filter/{id}', [WalletsController::class, 'walletFilter'])->name('wallets.filter');
    Route::get('/carteiras', [AppController::class, 'wallets'])->name('wallets');

    /*
     *  INVOICES
     */
    Route::group(['prefix' => 'faturas'], function() {
       Route::get('despesas/{status?}/{category?}/{date?}', [AppController::class, 'expenses'])->name('expenses');
       Route::get('receitas/{status?}/{category?}/{date?}', [AppController::class, 'incomes'])->name('incomes');
    });

    Route::post('invoices/filter', [InvoicesController::class, 'filter'])->name('invoices.filter');
    Route::resource('invoices', InvoicesController::class);
});
