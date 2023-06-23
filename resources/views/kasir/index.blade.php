@extends('layouts.main')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <h4 class="card-header">Daftar Anggota Kasir</h4>
            <div class="card-body">
                <div class="row justify-content-between px-2 my-3 align-items-center">
                    <div class="col-lg-6">
                      <a href="{{ route('kasir.create') }}" class="btn btn-sm btn-primary" style="width: max-content;height:max-content;"><i class='bx bx-plus' ></i> Tambah Kasir</a>
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
                        <th>Id Kasir</th>
                        <th>Foto</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Alamat</th>
                        <th>No Telpon</th>
                        <th>Tanggal Terdaftar</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach($kasir as $index => $k)
                            <tr>
                                <td>{{ $kasir->firstItem() + $index }}</td>
                                <td>{{ $k->id_kasir }}</td>
                                <td>
                                    <img src="{{ asset('storage/image_profile/') }}/{{ $k->image }}" alt="{{ $k->image }}" width="50">
                                </td>
                                <td>{{ $k->nama }}</td>
                                <td>{{ $k->email }}</td>
                                <td>{{ $k->alamat }}</td>
                                <td>{{ $k->no_telpon }}</td>
                                <td>{{ $k->created_at->format('d/M/Y') }}</td>
                                <td>
                                  <a href="{{ route('kasir.edit', $k->id) }}" class="btn btn-sm btn-primary" title="Edit"><i class="bx bx-edit-alt me-1"></i> Edit</a>
                                  <form class="d-inline" action="{{ route('kasir.destroy', $k->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"><i class="bx bx-trash me-1"></i> Delete</button>
                                  </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                  </table>
                  <div class="col-12 d-flex justify-content-end align-items-center">
                    {{ $kasir->links() }}
                  </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection