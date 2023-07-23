<?php

use App\Http\Controllers\API\APICartController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('cart', [APICartController::class, 'store'])->name('api.cart.post');
Route::post('cart/admin', [APICartController::class, 'store_admin'])->name('api.cart.post_admin');
Route::post('cart/update', [APICartController::class, 'update'])->name('api.cart.update');
Route::get('cart', [APICartController::class, 'getCountProduk'])->name('api.cart.count');
Route::get('cart/jumlah/{id}', [APICartController::class, 'getJumlahProduk'])->name('api.cart.count');
