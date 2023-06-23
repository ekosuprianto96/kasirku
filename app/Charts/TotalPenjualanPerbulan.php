<?php

namespace App\Charts;

use App\Models\BarangMasuk;
use App\Models\Transaction;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use Illuminate\Support\Carbon;

class TotalPenjualanPerbulan
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\BarChart
    {
        $bulanSekarang = Carbon::now()->format('m');
        $tahunSekarang = Carbon::now()->format('Y');
        if (intval($bulanSekarang) <= 6) {
            return $this->chart->barChart()
                ->setTitle('Total Penjualan')
                ->setSubtitle("Data Total Penjualan Tahun {$tahunSekarang}")
                ->addData('Total Transaki', [
                    Transaction::whereMonth('created_at', Carbon::JANUARY)->whereYear('created_at', Carbon::now()->format('Y'))->count(),
                    Transaction::whereMonth('created_at', Carbon::FEBRUARY)->whereYear('created_at', Carbon::now()->format('Y'))->count(),
                    Transaction::whereMonth('created_at', Carbon::MARCH)->whereYear('created_at', Carbon::now()->format('Y'))->count(),
                    Transaction::whereMonth('created_at', Carbon::APRIL)->whereYear('created_at', Carbon::now()->format('Y'))->count(),
                    Transaction::whereMonth('created_at', Carbon::MAY)->whereYear('created_at', Carbon::now()->format('Y'))->count(),
                    Transaction::whereMonth('created_at', Carbon::JUNE)->whereYear('created_at', Carbon::now()->format('Y'))->count()
                ])
                ->addData('Produk Keluar', [
                    Transaction::whereMonth('created_at', Carbon::JANUARY)->whereYear('created_at', Carbon::now()->format('Y'))->sum('jumlah'),
                    Transaction::whereMonth('created_at', Carbon::FEBRUARY)->whereYear('created_at', Carbon::now()->format('Y'))->sum('jumlah'),
                    Transaction::whereMonth('created_at', Carbon::MARCH)->whereYear('created_at', Carbon::now()->format('Y'))->sum('jumlah'),
                    Transaction::whereMonth('created_at', Carbon::APRIL)->whereYear('created_at', Carbon::now()->format('Y'))->sum('jumlah'),
                    Transaction::whereMonth('created_at', Carbon::MAY)->whereYear('created_at', Carbon::now()->format('Y'))->sum('jumlah'),
                    Transaction::whereMonth('created_at', Carbon::JUNE)->whereYear('created_at', Carbon::now()->format('Y'))->sum('jumlah')
                ])
                ->setXAxis(['January', 'February', 'March', 'April', 'May', 'June']);
        } else {
            return $this->chart->barChart()
                ->setTitle('Total Penjualan')
                ->setSubtitle("Data Total Penjualan Tahun {$tahunSekarang}")
                ->addData('Total Transaksi', [
                    Transaction::whereMonth('created_at', Carbon::JULY)->whereYear('created_at', Carbon::now()->format('Y'))->count(),
                    Transaction::whereMonth('created_at', Carbon::AUGUST)->whereYear('created_at', Carbon::now()->format('Y'))->count(),
                    Transaction::whereMonth('created_at', Carbon::SEPTEMBER)->whereYear('created_at', Carbon::now()->format('Y'))->count(),
                    Transaction::whereMonth('created_at', Carbon::OCTOBER)->whereYear('created_at', Carbon::now()->format('Y'))->count(),
                    Transaction::whereMonth('created_at', Carbon::NOVEMBER)->whereYear('created_at', Carbon::now()->format('Y'))->count(),
                    Transaction::whereMonth('created_at', Carbon::DECEMBER)->whereYear('created_at', Carbon::now()->format('Y'))->count()
                ])
                ->addData('Produk Keluar', [
                    Transaction::whereMonth('created_at', Carbon::JULY)->whereYear('created_at', Carbon::now()->format('Y'))->sum('jumlah'),
                    Transaction::whereMonth('created_at', Carbon::AUGUST)->whereYear('created_at', Carbon::now()->format('Y'))->sum('jumlah'),
                    Transaction::whereMonth('created_at', Carbon::SEPTEMBER)->whereYear('created_at', Carbon::now()->format('Y'))->sum('jumlah'),
                    Transaction::whereMonth('created_at', Carbon::OCTOBER)->whereYear('created_at', Carbon::now()->format('Y'))->sum('jumlah'),
                    Transaction::whereMonth('created_at', Carbon::NOVEMBER)->whereYear('created_at', Carbon::now()->format('Y'))->sum('jumlah'),
                    Transaction::whereMonth('created_at', Carbon::DECEMBER)->whereYear('created_at', Carbon::now()->format('Y'))->sum('jumlah')
                ])
                ->setXAxis(['Juli', 'Agustus', 'September', 'Oktober', 'November', 'September']);
        }
    }
}
