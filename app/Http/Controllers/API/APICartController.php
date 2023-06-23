<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Produk;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class APICartController extends Controller
{
    public function store(Request $request)
    {
        $produk = Produk::findOrFail($request->id);
        $checkCart = Cart::where('produk_id', $produk->id)->first();
        $countCart = null;
        if ($produk !== null) {
            if (isset($checkCart)) {
                $cart = Cart::where('produk_id', $produk->id)->first();
                $cart->jumlah += 1;
                $cart->save();
            } else {
                Cart::create([
                    'produk_id' => $produk->id,
                    'nama_produk' => $produk->name,
                    'satuan' => $produk->satuan,
                    'harga' => $produk->harga,
                    'jumlah' => 1
                ]);
            }
        }

        return response()->json([
            'status' => true,
            'produk' => $produk
        ]);
    }
    public function getCountProduk()
    {
        return response()->json([
            'count' => $cart = Cart::all()->count()
        ]);
    }
    public function update(Request $request)
    {
        $cart = Cart::find($request->id);
        $cart->jumlah = $request->jumlah;
        $allCart = Cart::with('produk')->get();
        $totalHarga = 0;
        foreach ($allCart as $c) {
            $harga = $c->harga * $c->jumlah;
            $totalHarga += $harga;
        }
        $cart->save();
        return response()->json([
            'status' => true,
            'jumlah' => $cart->jumlah,
            'total' => $totalHarga
        ]);
    }
    public function getJumlahProduk($id)
    {
        $produk = Cart::where('produk_id', $id)->first();

        return response()->json([
            'status' => true,
            'jumlah' => $produk->jumlah
        ]);
    }
}
