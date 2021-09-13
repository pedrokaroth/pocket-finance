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
}
