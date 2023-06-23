<?php

namespace App\Http\Controllers\Dashboard;

use App\Charts\TotalPenjualanPerbulan;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(TotalPenjualanPerbulan $chart)
    {
        return view('index', [
            'title' => 'Dashboard',
            'active' => 'dashboard',
            'chart' => $chart->build()
        ]);
    }
}
