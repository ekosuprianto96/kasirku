@extends('layouts.main')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <h4 class="card-header">Daftar Barang Masuk</h4>
            <div class="card-body">
                <div class="row justify-content-between px-2 my-3 align-items-center">
                    <div class="col-lg-6">
                      <a href="" class="btn btn-sm btn-primary" style="width: max-content;height:max-content;"><i class='bx bxs-printer' ></i> Cetak PDF</a>
                      <a href="javascript:void(0)" data-bs-target="#modalFilter" data-bs-toggle="modal" class="btn btn-sm btn-secondary shadow-sm"><i class='bx bx-filter-alt'></i> Filter</a>

                      {{-- Modal --}}
                      <div class="modal fade" id="modalFilter" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modalFilterTitle">Filter Berdasarkan Tanggal</h5>
                                    <button
                                        type="button"
                                        class="btn-close"
                                        data-bs-dismiss="modal"
                                        aria-label="Close"
                                    ></button>
                                </div>
                                <form action="{{ route('barang-masuk') }}">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-lg-12 mb-3">
                                                <label for="start_date">Mulai Tanggal</label>
                                                <input type="date" name="start_date" id="start_date" class="form-control">
                                            </div>
                                            <div class="col-lg-12 mb-3">
                                                <label for="end_date">Sampai Tanggal</label>
                                                <input type="date" name="end_date" id="end_date" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                        Batal
                                        </button>
                                        <button type="submit" class="btn btn-primary">Terapkan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    </div>
                    <div class="col-lg-3">
                      <div class="input-group input-group-merge">
                        <span class="input-group-text" id="basic-addon-search31"><i class="bx bx-search"></i></span>
                        <input
                          type="text"
                          class="form-control"
                          placeholder="Search..."
                          aria-label="Search..."
                          aria-describedby="basic-addon-search31"
                        />
                      </div>
                    </div>
                </div>
                <div class="table-responsive text-nowrap">
                  <table class="table">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Barcode Produk</th>
                        <th>Image</th>
                        <th>Nama Produk</th>
                        <th>Kategori</th>
                        <th>Jumlah</th>
                        <th>Harga</th>
                        <th>Satuan</th>
                        <th>Tanggal</th>
                      </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                      @foreach($barang as $index => $b)
                      <tr>
                        <td>{{ $barang->firstItem() + $index }}</td>
                        <td>{{ $b->produk->barcode }}</td>
                        <td>
                            <img src="{{ asset('storage/produk/') }}/{{ $b->produk->image }}" alt="Avatar" width="50" />
                        </td>
                        <td><strong>{{ $b->nama_produk }}</strong></td>
                        <td>{{ $b->produk->kategori->name }}</td>
                        <td>{{ $b->jumlah }}</td>
                        <td>@currency($b->produk->harga)</td>
                        <td>{{ $b->satuan }}</td>
                        <td class="text-center">{{ $b->created_at->format('d/M/Y') }}</td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection