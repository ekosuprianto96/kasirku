<?php

namespace App\Http\Controllers\Order;

use App\Models\Cart;
use App\Models\Produk;
use App\Models\Transaction;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;

class OrderController extends Controller
{
    public function index()
    {
        return view('transaksi.index', [
            'title' => 'Buat Pesanan',
            'active' => 'buat pesanan',
            'produk' => Produk::with('kategori')->where('deleted_at', null)->get()
        ]);
    }
    public function checkout()
    {
        $cart = Cart::where('jumlah', '>', 0)->get();
        if (isset($cart)) {
            foreach ($cart as $c) {
                if ($c->jumlah <= $c->produk->stok && $c->produk->stok > 0) {
                    Transaction::create([
                        'produk_id' => $c->produk_id,
                        'kode_transaksi' => Str::upper(Str::random(3) . mt_rand(0, 9) . Str::random(2) . mt_rand(10, 99) . Str::random(3)),
                        'nama_produk' => $c->nama_produk,
                        'kategori' => $c->produk->kategori->name,
                        'satuan' => $c->satuan,
                        'harga_satuan' => $c->harga,
                        'harga_total' => $c->harga * $c->jumlah,
                        'jumlah' => $c->jumlah
                    ]);
                    $produk = Produk::find($c->produk_id);
                    $produk->stok -= $c->jumlah;
                    $produk->save();
                    if ($produk->save()) {
                        $c->delete();
                    }
                    Alert::success('Sukses', 'Transaksi Berhasil!');
                } else {
                    Alert::error('Gagal', 'Stok Tidak Mencukupi!');
                }
            }
        }


        return redirect()->back();
    }
}
