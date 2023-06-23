<?php

namespace App\Http\Controllers\BarangMasuk;

use App\Http\Controllers\Controller;
use App\Models\BarangMasuk;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;

class BarangMasukController extends Controller
{
    public function index(Request $request)
    {
        $barang = null;
        if (isset($request->start_date) && isset($request->end_date)) {
            $start_date = Carbon::parse($request->start_date)->toDateTimeString();
            $end_date = Carbon::parse($request->end_date)->toDateTimeString();
            $barang = BarangMasuk::with('produk')->where(function ($query) use ($start_date, $end_date) {
                $query->whereBetween('created_at', [$start_date, $end_date]);
            })->latest()->paginate(10);
        } else {
            $barang = BarangMasuk::with('produk')
                ->latest()->paginate(10);
        }
        return view('barangMasuk.barangmasuk', [
            'title' => 'Barang Masuk',
            'active' => 'laporan',
            'barang' => $barang
        ]);
    }
    // public function filter()
    // {
    //     $barang = [];
    //      else {
    //         $barang = BarangMasuk::with('produk')->where('created_at', $request->start_date)->paginate(10);
    //     }


    //     return view('barangMasuk.barangmasuk', [
    //         'title' => 'Barang Masuk',
    //         'active' => 'laporan',
    //         'barang' => $barang
    //     ]);
    // }
}
