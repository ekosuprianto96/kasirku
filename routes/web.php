<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\BarangKeluar\BarangKeluarController;
use App\Http\Controllers\BarangMasuk\BarangMasukController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\DashboardKasir\DashboardController as DashboardKasir;
use App\Http\Controllers\Kasir\KasirController;
use App\Http\Controllers\Kategori\KategoriController;
use App\Http\Controllers\Keranjang\KeranjangController;
use App\Http\Controllers\Order\OrderController;
use App\Http\Controllers\Produk\ProdukController;
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

Route::group(['middleware' => ['auth', 'admin']], function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('produk', ProdukController::class);
    Route::resource('kategori', KategoriController::class);
    Route::get('barang-masuk', [BarangMasukController::class, 'index'])->name('barang-masuk');
    Route::post('barang-masuk/filter', [BarangMasukController::class, 'filter'])->name('barang-masuk.filter');
    Route::get('buat-pesanan', [OrderController::class, 'index'])->name('buat-pesanan');
    Route::get('keranjang', [KeranjangController::class, 'index'])->name('keranjang');
    Route::post('checkout', [OrderController::class, 'checkout'])->name('checkout');
    Route::get('barang-keluar', [BarangKeluarController::class, 'index'])->name('barang-keluar');
    Route::get('kasir', [KasirController::class, 'index'])->name('kasir');
    Route::get('kasir/create', [KasirController::class, 'create'])->name('kasir.create');
    Route::post('kasir', [KasirController::class, 'store'])->name('kasir.store');
    Route::get('kasir/edit/{id}', [KasirController::class, 'edit'])->name('kasir.edit');
    Route::put('kasir/update/{id}', [KasirController::class, 'update'])->name('kasir.update');
    Route::delete('kasir/destroy/{id}', [KasirController::class, 'destroy'])->name('kasir.destroy');
});
Route::get('dashboard-kasir', [DashboardKasir::class, 'index'])->name('dashboard-kasir')->middleware('auth');
Route::post('logout', [LoginController::class, 'logout'])->name('logout');
Route::middleware('guest')->group(function () {
    Route::get('/', [LoginController::class, 'index'])->name('login');
    Route::post('login', [LoginController::class, 'authenticate'])->name('login.authenticate');
});
