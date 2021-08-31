<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Http\Requests\Invoice;
use Illuminate\Contracts\Foundation\Application;
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
        return view('app.wallets', [
            'wallets' => user()->wallets()->get()
        ]);
    }

    /**
     *  Show the invoices view with expenses
     *
     * @return View
     */
    public function expenses(): View
    {
        return view('app.invoices', [
            'invoices' => walletactive()->expenses(),
            'type' => 'expense'
        ]);
    }

    /**
     * Shpw the invoices with incomes
     *
     * @return View
     */
    public function incomes(): View
    {
        return view('app.invoices', [
           'invoices' => walletactive()->incomes(),
           'type' => 'income'
        ]);
    }
}
