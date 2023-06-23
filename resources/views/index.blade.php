@extends('layouts.main')

@section('content')
<div class="row">
    <div class="col-lg-12 order-1">
        <div class="row">
            <div class="col-lg-4 col-md-12 col-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-4 border-end d-flex justif-content-center align-items-center">
                                <i class='bx bx-shopping-bag' style="font-size: 2em"></i>
                            </div>
                            <div class="col-8">
                                <span class="d-block" style="font-size: 1em"><strong>{{ App\Models\Produk::where('deleted_at', null)->count() }}</strong></span>
                                <span class="d-block" style="font-size: 1em"><strong>Produk</strong></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-12 col-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-4 border-end d-flex justif-content-center align-items-center">
                                <i class='bx bx-cart-alt' style="font-size: 2em"></i>
                            </div>
                            <div class="col-8">
                                <span class="d-block" style="font-size: 1em"><strong>{{ App\Models\Transaction::count() }}</strong></span>
                                <span class="d-block" style="font-size: 1em"><strong>Penjualan</strong></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-12 col-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-4 border-end d-flex justif-content-center align-items-center">
                                <i class='bx bx-wallet' style="font-size: 2em"></i>
                            </div>
                            <div class="col-8">
                                <span class="d-block" style="font-size: 1em"><strong>@currency(App\Models\Transaction::sum('harga_total'))</strong></span>
                                <span class="d-block" style="font-size: 1em"><strong>Pemasukan</strong></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        {{ $chart->container() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/ Order Statistics -->
</div>
<script src="{{ $chart->cdn() }}"></script>

{{ $chart->script() }}
@endsection