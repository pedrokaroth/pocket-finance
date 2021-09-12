<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Models\App\Invoice;
use Illuminate\Contracts\Support\Renderable;
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
        return view('app.home', [
            'chartData' => (new Invoice())->dashboardChartData()
        ]);
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
     * @param mixed $status
     * @param mixed $category
     * @param mixed $date
     * @return View
     */
    public function expenses($status = 'all', $category = 'all', $date = 'all'): View
    {
        return view('app.invoices', [
            'invoices' => walletactive()->expenses($status, $category, $date),
            'filter' => [
                'status' => $status ?? null,
                'category' => $category ?? null,
                'date' => !empty($date) && $date != 'all' ?
                    explode('-', $date)[0] . '/' . explode('-', $date)[1] : 'all'
            ],
            'type' => 'expense'
        ]);
    }


    /**
     * @param mixed $status
     * @param mixed $category
     * @param mixed $date
     * @return View
     */
    public function incomes($status = 'all', $category = 'all', $date = 'all'): View
    {

        return view('app.invoices', [
           'invoices' => walletactive()->incomes($status, $category, $date),
            'filter' => [
                'status' => $status ?? null,
                'category' => $category ?? null,
                'date' => !empty($date) && $date != 'all' ?
                    explode('-', $date)[0] . '/' . explode('-', $date)[1] : 'all'
            ],
           'type' => 'income'
        ]);
    }

    public function fixed()
    {
        return view('app.invoices', [
           'invoices' => walletactive()->fixed(),
           'type' => 'fixed'
        ]);
    }
}
