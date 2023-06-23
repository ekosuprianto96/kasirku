<?php

namespace App\BarangMasuk;

use App\Models\BarangMasuk;
use App\Models\Produk;

class CreateBarangMasuk
{

    public function create($produk, $request = null)
    {
        $barangMasuk = new BarangMasuk();
        $barangMasuk->nama_produk = $produk->name;
        $barangMasuk->produk_id = $produk->id;
        $barangMasuk->jumlah = $request;
        $barangMasuk->satuan = $produk->satuan;
        $barangMasuk->save();
    }
}
