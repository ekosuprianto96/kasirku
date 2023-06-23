@extends('layouts.main')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <h4 class="card-header">Daftar Produk</h4>
            <div class="card-body">
                <div class="row justify-content-between px-2 my-3 align-items-center">
                    <div class="col-lg-6">
                      <a href="{{ route('produk.create') }}" class="btn btn-sm btn-primary" style="width: max-content;">Tambah Produk</a>
                      <a href="" class="btn btn-sm btn-primary" style="width: max-content;height:max-content;"><i class='bx bxs-printer' ></i> Cetak PDF</a>
                    </div>
                    <div class="col-lg-4">
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
                        <th>Image</th>
                        <th>Nama Produk</th>
                        <th>Kategori</th>
                        <th>Barcode</th>
                        <th>Harga</th>
                        <th>Satuan</th>
                        <th>Jumlah Stok</th>
                        <th>Actions</th>
                      </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                      @foreach($produk as $index => $p)
                      <tr>
                        <td>{{ $produk->firstItem() + $index }}</td>
                        <td>
                            <img src="{{ asset('storage/produk/') }}/{{ $p->image }}" alt="Avatar" width="50" />
                        </td>
                        <td><strong>{{ $p->name }}</strong></td>
                        <td>{{ $p->kategori->name }}</td>
                        <td>{{ $p->barcode }}</td>
                        <td>@currency($p->harga)</td>
                        <td>{{ $p->satuan }}</td>
                        <td class="text-center">{{ $p->stok }}</td>
                        <td>
                          <a class="btn btn-sm btn-primary btn-edit" 
                              href="javascript:void(0)"
                              data-bs-toggle="modal"
                              data-bs-target="#modalTambahStok-{{ $p->id }}"
                                ><i class="bx bx-plus me-1"></i> Tambah Stok</a
                              >
                          <a class="btn btn-sm btn-primary btn-edit" 
                              href="{{ route('produk.edit', $p->id) }}"
                                ><i class="bx bx-edit-alt me-1"></i> Edit</a
                              >
                            <form class="d-inline" action="{{ route('produk.destroy', $p->id) }}" method="POST">
                              @csrf
                              @method('DELETE')
                              <button type="submit" class="btn btn-sm btn-danger"><i class="bx bx-trash me-1"></i> Delete</button>
                            </form>
                        </td>

                        {{-- Modal Tambah Stok --}}
                        <div class="modal fade" id="modalTambahStok-{{ $p->id }}" tabindex="-1" aria-hidden="true">
                          <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="modalTambahStokTitle">Tambah Stok</h5>
                                <button
                                  type="button"
                                  class="btn-close"
                                  data-bs-dismiss="modal"
                                  aria-label="Close"
                                ></button>
                              </div>
                              <form action="{{ route('produk.update', $p->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-body">
                                  <div class="row">
                                    <div class="col-lg-12">
                                      <input type="number" name="stok" id="name" placeholder="Stok" value="0" class="form-control">
                                    </div>
                                  </div>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                    Batal
                                  </button>
                                  <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                              </form>
                            </div>
                          </div>
                        </div>
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