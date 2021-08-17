<?php

use App\Http\Controllers\AppController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
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

Auth::routes();

Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->name('verification.notice')->middleware('auth');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect('/home');
})->name('verification.verify')->middleware(['auth', 'signed']);

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('message', 'Verification link sent!');
})->name('verification.resend')->middleware(['auth', 'throttle:6,1']);

Route::group(['middleware' => ['auth', 'verified'], 'prefix' => 'app'], function() {
    Route::get('/', [
      AppController::class, 'home'
    ])->name('app.home');
});

Route::get('/teste', function() {
    return view('auth.login');
});
