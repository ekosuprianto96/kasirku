<?php

namespace App\Http\Controllers\DashboardKasir;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $produk = Produk::whereNull('deleted_at')->get();
        return view('dashboardKasir.index', compact('produk'));
    }
}
