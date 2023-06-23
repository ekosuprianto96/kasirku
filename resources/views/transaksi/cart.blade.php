 @extends('layouts.main')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <h4 class="card-header">Keranjang</h4>
            <div class="card-body">
                @if($cart->count() > 0)
                    <table class="w-100">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Image</th>
                                <th>Nama Produk</th>
                                <th>Harga Satuan</th>
                                <th>Total Harga</th>
                                <th>Tanggal</th>
                                <th>Stok</th>
                                <th>Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cart as $index => $c)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td class="py-2">
                                    <img src="{{ asset('storage/produk/') }}/{{ $c->produk->image }}" alt="" width="100">
                                </td>
                                <td>{{ $c->nama_produk }}</td>
                                <td>@currency($c->harga)</td>
                                <td>@currency($c->harga * $c->jumlah)</td>
                                <td>{{ $c->created_at->format('d/M/Y') }}</td>
                                <td>{{ $c->produk->stok }}</td>
                                <td>
                                    <input class="form-control" type="number" data-id-cart="{{ $c->id }}" onblur="updateCart(event)" value="{{ $c->jumlah }}" style="width: 100px;">
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="bg-dark mt-3" style="color: white;">
                            <tr>
                                <td></td>
                                <td class="p-3"><strong>Total</strong></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td class="p-3 text-end"><strong id="totalHarga">@currency($total)</strong></td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                    <div class="col-12 mt-3">
                        <form action="{{ route('checkout') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-primary">Checkout</button>
                        </form>
                    </div>
                @else 
                    <div class="col-12 text-center p-4">
                        <h3>Keranjang Anda Masih Kosong.</h3>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
<script>
    function updateCart(e) {
        const idProduk = e.target.getAttribute('data-id-cart');
        const __token = `{{ csrf_token() }}`;
        const dataForm = {
            id: idProduk,
            jumlah: e.target.value
        };
        fetch(`{{ route('api.cart.update') }}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': __token,
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(dataForm)
        }).then(response => response.json())
        .then(result => {
            if(result.status) {
                e.target.value = result.jumlah
                window.location.href = `{{ route('keranjang') }}`
            }
        })
    }
</script>
@endsection