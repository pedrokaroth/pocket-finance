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
    Route::group(['prefix' => 'carteiras', 'as' => 'wallets.'], function() {
        Route::post('filtrar/{id}', [WalletsController::class, 'walletFilter'])->name('filter');
        Route::get('/', [WalletsController::class, 'index'])->name('index');
    });

    /*
     *  INVOICES
     */
    Route::group(['prefix' => 'faturas', 'middleware' => 'fixed', 'as' => 'invoices.'], function() {
        Route::post('filtrar', [InvoicesController::class, 'filter'])->name('filter');
        Route::get('fixas', [InvoicesController::class, 'fixed'])->name('fixed');
        Route::get('parceladas', [InvoicesController::class, 'installments'])->name('installments');
        Route::post('clone/{invoice}', [InvoicesController::class, 'clone'])->name('clone')->withoutMiddleware('fixed');
        Route::put('status/{invoice}', [InvoicesController::class, 'setStatus'])->name('status')->withoutMiddleware('fixed');
        Route::get('despesas/{status?}/{category?}/{date?}', [InvoicesController::class, 'expenses'])->name('expenses');
        Route::get('receitas/{status?}/{category?}/{date?}', [InvoicesController::class, 'incomes'])->name('incomes');
    });

    Route::resource('invoices', InvoicesController::class);
    Route::resource('wallets', WalletsController::class);
});
