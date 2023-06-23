@extends('layouts.main')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <h4 class="card-header">Tambah Produk</h4>
            <div class="card-body">
                <form action="{{ route('produk.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="row">
                                <div class="col-lg-12 mb-4">
                                    <label for="name" class="form-label">Nama Produk</label>
                                    <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="Nama Produk" required>
                                    @error('name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-lg-12 mb-4">
                                    <label for="kategori" class="form-label">Kategori</label>
                                    <select name="kategori" id="kategori" class="form-control @error('kategori') is-invalid @enderror" required>
                                        <option selected>Pilih Kategori</option>
                                        @foreach($kategori as $k)
                                        <option value="{{ $k->id }}">{{ $k->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('kategori')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-lg-6 mb-4">
                                    <label for="harga" class="form-label">Harga</label>
                                    <input type="number" name="harga" id="harga" value="{{ old('harga') }}" class="form-control @error('harga') is-invalid @enderror" placeholder="Harga" required>
                                    @error('harga')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-lg-6 mb-4">
                                    <label for="satuan" class="form-label">Satuan</label>
                                    <input type="text" name="satuan" id="satuan" value="{{ old('satuan') }}" class="form-control @error('satuan') is-invalid @enderror" placeholder="satuan: contoh 'pcs'">
                                    @error('satuan')
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
                                                <i class='bx bx-image-add' style="font-size: 2em;"></i>
                                            </span>
                                            <span class="d-block" style="font-weight: bold;">Tambahkan Gambar</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <button class="btn btn-primary" type="submit">Tambah Produk</button>
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