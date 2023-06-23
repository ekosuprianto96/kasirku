@extends('layouts.main')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <h4 class="card-header">Edit Kasir</h4>
            <div class="card-body">
                <form action="{{ route('kasir.update', $kasir->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="row">
                                <div class="col-lg-6 mb-4">
                                    <label for="name" class="form-label">Nama</label>
                                    <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ $kasir->nama }}" placeholder="nama" required>
                                    @error('name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-lg-6 mb-4">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" name="email" id="email" value="{{ $kasir->email }}" class="form-control @error('email') is-invalid @enderror" placeholder="email" required>
                                    @error('email')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-lg-6 mb-4">
                                    <label for="alamat" class="form-label">Alamat</label>
                                    <input type="text" name="alamat" id="alamat" value="{{ $kasir->alamat }}" class="form-control @error('alamat') is-invalid @enderror" placeholder="alamat" required>
                                    @error('alamat')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-lg-6 mb-4">
                                    <label for="no_telpon" class="form-label">No Telpon</label>
                                    <input type="text" name="no_telpon" id="no_telpon" value="{{ $kasir->no_telpon }}" class="form-control @error('no_telpon') is-invalid @enderror" placeholder="no telpon" required>
                                    @error('no_telpon')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="card">
                                <h4 class="card-header">Image</h4>
                                <div class="card-body">
                                    <div class="col-12 mb-3">
                                        <div id="img-prev" class="relative w-100 d-flex flex-column justify-content-center align-items-center border p-3" style="max-height: max-content;min-height: 200px;border-radius: 7px;">
                                            <input type="file" onchange="previewImage(event)" name="image" class="absolute w-100 h-100" id="image" style="opacity: 0">
                                            <span class="d-block">
                                                @if($kasir->image === null)
                                                <i class='bx bx-image-add' style="font-size: 2em;"></i>
                                                @else
                                                <img src="{{ asset('storage/image_profile/') }}/{{ $kasir->image }}" alt="{{ $kasir->image }}" class="w-100">
                                                @endif
                                            </span>
                                            <span class="d-block" style="font-weight: bold;">Tambahkan Gambar</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <button class="btn btn-primary" type="submit">Update Kasir</button>
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