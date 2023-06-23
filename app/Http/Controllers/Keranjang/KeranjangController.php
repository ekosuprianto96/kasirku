<?php

namespace App\Http\Controllers\Keranjang;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use Illuminate\Http\Request;

class KeranjangController extends Controller
{
    public function index()
    {
        $cart = Cart::with('produk')->where('jumlah', '>', 0)->get();
        $cart_row = Cart::where('jumlah', '=', 0)->get();
        foreach ($cart_row as $cr) {
            $cr->delete();
        }
        $totalHarga = 0;
        foreach ($cart as $c) {
            $harga = $c->harga * $c->jumlah;
            $totalHarga += $harga;
        }
        return view('transaksi.cart', [
            'title' => 'Keranjang',
            'active' => 'keranjang',
            'cart' => $cart,
            'total' => $totalHarga
        ]);
    }
}
