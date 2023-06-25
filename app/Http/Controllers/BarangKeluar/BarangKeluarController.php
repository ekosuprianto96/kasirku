<?php

namespace App\Http\Controllers\BarangKeluar;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;

class BarangKeluarController extends Controller
{
    public function index(Request $request)
    {
        $barang =  null;
        if (isset($request->start_date) && isset($request->end_date)) {
            $start_date = Carbon::parse($request->start_date)->toDateTimeString();
            $end_date = Carbon::parse(($request->end_date))->toDateTimeString();
            $barang = Transaction::with('produk')->where(function ($query) use ($start_date, $end_date) {
                $query->whereBetween('created_at', [$start_date, $end_date]);
            })->latest()->paginate(10);
        } else {
            $barang = Transaction::latest()->paginate(10);
        }
        return view('barangKeluar.index', [
            'title' => 'Barang Keluar',
            'active' => 'laporan',
            'barang' => $barang
        ]);
    }
    public function cetak(Request $request) {
        $barang = Transaction::whereMonth('created_at', Carbon::now()->format('m'))
        ->whereYear('created_at', Carbon::now()->format('Y'))->latest()->get();
        // dd($barang);
        $pdf = Pdf::loadView('barangKeluar.pdf', compact('barang'));
        return $pdf->download('Laporan.pdf');
    }
}
