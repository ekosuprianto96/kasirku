@extends('layouts.main')

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <h4 class="card-header">Daftar Kategori</h4>
            <div class="card-body">
                <div class="row justify-content-between px-2 my-3 align-items-center">
                    <div class="col-lg-6">
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
                        <th>Nama</th>
                        <th class="text-center">Actions</th>
                      </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                      @foreach($kategori as $index => $k)
                      <tr>
                        <td>{{ $kategori->firstItem() + $index }}</td>
                        <td>
                            <img src="{{ asset('storage/kategori/') }}/{{ $k->image }}" alt="Avatar" width="50" />
                        </td>
                        <td><strong>{{ $k->name }}</strong></td>
                        <td class="text-center">
                          <a class="btn btn-sm btn-primary btn-edit" 
                              data-bs-toggle="modal"
                              data-bs-target="#modalEdit-{{ $k->id }}"
                              href="javascript:void(0);"
                              data-id="{{ $k->id }}"
                                ><i class="bx bx-edit-alt me-1"></i> Edit</a
                              >
                            <form class="d-inline" action="{{ route('kategori.destroy', $k->id) }}" method="POST">
                              @csrf
                              @method('DELETE')
                              <button type="submit" class="btn btn-sm btn-danger"><i class="bx bx-trash me-1"></i> Delete</button>
                            </form>
                        </td>
                        {{-- Modal Edit --}}
                        <div class="modal fade" id="modalEdit-{{ $k->id }}" tabindex="-1" aria-hidden="true">
                          <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="modalEditTitle">Edit Kategori</h5>
                                <button
                                  type="button"
                                  class="btn-close"
                                  data-bs-dismiss="modal"
                                  aria-label="Close"
                                ></button>
                              </div>
                              <form action="{{ route('kategori.update', $k->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="modal-body">
                                  <div class="row">
                                    <div class="col-12 mb-3">
                                      <div class="relative w-100 d-flex flex-column justify-content-center align-items-center border p-3" style="max-height: max-content;min-height:50px;border-radius: 7px;">
                                        <input type="file" onchange="previewImage(event)" name="image" class="absolute w-100 h-100 image-{{ $k->id }}" id="image-{{ $k->id }}" style="opacity: 0">
                                        <span class="d-block">
                                          {{-- <i class='bx bx-image-add' style="font-size: 2em;"></i> --}}
                                          <img src="{{ asset('storage/kategori/') }}/{{ $k->image }}" width="100" alt="">
                                        </span>
                                        <span class="d-block" style="font-weight: bold;">Tambahkan Gambar</span>
                                      </div>
                                    </div>
                                    <div class="col-lg-12">
                                      <input type="text" name="name" id="name" placeholder="Nama Kategori" value="{{ $k->name }}" class="form-control">
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
                  <div class="row">
                    <div class="col-12">
                        {{ $kategori->links() }}
                      </div>
                  </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
      <div class="card">
        <h4 class="card-header">Tambah Kategori</h4>
        <div class="card-body">
          <form action="{{ route('kategori.store') }}" class="w-100 h-100" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
              <div class="col-12 mb-3">
                <div id="img-prev" class="relative w-100 d-flex flex-column justify-content-center align-items-center border p-3" style="max-height: max-content;min-height:50px;border-radius: 7px;">
                  <input type="file" onchange="previewImage(event)" name="image" class="absolute w-100 h-100" id="image" style="opacity: 0">
                  <span class="d-block">
                    <i class='bx bx-image-add' style="font-size: 2em;"></i>
                  </span>
                  <span class="d-block" style="font-weight: bold;">Tambahkan Gambar</span>
                </div>
              </div>
              <div class="col-12 mb-3">
                <input type="text" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" name="name" id="name" placeholder="Nama Kategori" required>
                @error('name')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                @enderror
              </div>
              <div class="col-12">
                <button type="submit" class="btn btn-primary w-100">Tambah Kategori</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
</div>

<script>
  function previewImage(e) {
    const file = e.target.files[0];
    const src = URL.createObjectURL(file);
    e.target.nextElementSibling.innerHTML = `<img src="${src}" class="img-prev" />`
  }
</script>
@endsection