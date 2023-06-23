 @extends('layouts.main')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <h4 class="card-header">Buat Pesanan</h4>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12" style="max-height: 400px;overflow:auto;">
                        <h5>Pilih Produk</h5>
                        <div class="row">
                            @foreach($produk as $p)
                            <div class="col-lg-2 mb-3" style="max-height: 200px;">
                                <div class="w-100 relative">
                                    <div class="w-100 d-flex justify-content-center align-items-center" style="height: 100px;overflow:hidden">
                                        <img src="{{ asset('storage/produk/') }}/{{ $p->image }}" alt="" width="100%">
                                    </div>
                                    <span class="d-block mt-2"><strong>{{ $p->name }}</strong></span>
                                    <span class="d-block">@currency($p->harga)</span>
                                    <span class="d-block">Stok: {{ $p->stok }}</span>
                                    <button {{ $p->stok <= 0 ? 'disabled' : '' }} data-id-produk="{{ $p->id }}" class="btn btn-sm btn-primary button-add-cart mt-2 d-flex justify-content-center align-items-center w-100"><i class='bx bxs-cart-add me-2'></i> Pilih</button>
                                    <span class="absolute jumlah-produk rounded-circle {{ $p->cart === null ? 'd-none' : 'd-flex' }} justify-content-center align-items-center" style="top:10px;right: 10px;background-color: red;width:20px;height:20px;font-size:0.6em;color:white;">{{ $p->cart === null ? '0' : $p->cart->jumlah }}</span>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    const btnAddCart = document.querySelectorAll('.button-add-cart');
    const __token = `{{ csrf_token() }}`;
    const totalCart = document.querySelector('#total-cart');
    document.addEventListener('DOMContentLoaded', () => {
        updateCount(totalCart)
    })
    let datas;
    btnAddCart.forEach(element => {
        element.addEventListener('click', (e) => {
            if(e.target.tagName == 'BUTTON') {
                const idProduk = e.target.getAttribute('data-id-produk');
                addCart(idProduk, totalCart, element);
                updateJumlah(e.target.nextElementSibling, idProduk);
            }
        })
    });
    function addCart(idProduk, totalCart, button) {
        const dataForm = {
            id: idProduk
        };
        fetch(`{{ route('api.cart.post') }}`, {
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
                if(result.disable) {
                    button.setAttribute('disabled', '');
                }
                if(totalCart.classList.contains('d-none')) {
                    totalCart.classList.replace('d-none', 'd-flex');
                }
                updateCount(totalCart);
                
            }
        })

    }
    
</script>
@endsection