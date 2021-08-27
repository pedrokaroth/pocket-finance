<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

/**
 * Class AppController
 * @package App\Http\Controllers\App
 */
class AppController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return Renderable
     */
    public function home(): Renderable
    {
        return view('app.home');
    }

    /**
     *  Show the application wallets.
     *
     * @return View
     */
    public function wallets(): View
    {
        $wallets = Auth::user()->wallets()->get();

        return view('app.wallets', [
            'wallets' => $wallets
        ]);
    }
}
