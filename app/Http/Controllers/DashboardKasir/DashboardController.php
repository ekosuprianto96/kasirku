<?php

namespace App\Http\Controllers\DashboardKasir;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use App\Models\Produk;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $produk = Produk::whereNull('deleted_at')->get();
        $kategori = Kategori::all();
        return view('dashboardKasir.index', compact('produk', 'kategori'));
    }
}
