<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Support\Renderable;

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
            'chartData' => InvoiceService()->getDashboardChart()
        ]);
    }
}
