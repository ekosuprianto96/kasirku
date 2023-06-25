<?php

namespace App\Http\Controllers\API;

use App\Models\Cart;
use App\Models\Produk;
use App\Models\Transaction;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use GrahamCampbell\ResultType\Success;
use RealRashid\SweetAlert\Facades\Alert;

class APICartController extends Controller
{
    public function store(Request $request)
    {
        if($request->carts) {
            $carts = json_decode($request->carts);
            foreach($carts as $key => $cart) {
                if($cart->total != 0) {
                    $produk = Produk::where('barcode', $cart->barcode)->first();
                    Transaction::create([
                        'produk_id' => $produk->id,
                        'kode_transaksi' => Str::upper(Str::random(3) . mt_rand(0, 9) . Str::random(2) . mt_rand(10, 99) . Str::random(3)),
                        'nama_produk' => $produk->name,
                        'kategori' => $produk->kategori->name,
                        'satuan' => $produk->satuan,
                        'harga_satuan' => $produk->harga,
                        'harga_total' => $produk->harga * intval($cart->total),
                        'jumlah' => $cart->total
                    ]);
                    $produk->stok -= intval($cart->total);
                    $produk->save();
                    // Alert::success('Sukses', 'Transaksi Berhasil!');
                    
                }
                
            }
            return response()->json([
                'status' => true,
                'message' => 'Berhasil Checkout'
            ]);
        }
        
    }
    public function getCountProduk()
    {
        return response()->json([
            'count' => $cartart = Cart::all()->count()
        ]);
    }
    public function update(Request $request)
    {
        $cartart = Cart::find($request->id);
        $cartart->jumlah = $request->jumlah;
        $allCart = Cart::with('produk')->get();
        $totalHarga = 0;
        foreach ($allCart as $cart) {
            $harga = $cart->harga * $cart->jumlah;
            $totalHarga += $harga;
        }
        $cartart->save();
        return response()->json([
            'status' => true,
            'jumlah' => $cartart->jumlah,
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
