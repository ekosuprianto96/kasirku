<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>

    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
     <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
      rel="stylesheet"
    />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  </head>
  <body style="background-color: rgb(230, 230, 230);font-family: Public Sans;">
    
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-8 p-4">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <div class="d-flex flex-nowrap justify-content-start align-items-center overflow-hidden">
                                    @foreach($kategori as $kat)
                                    <div class="kategori-card me-3 position-relative border rounded-2 overflow-hidden d-flex justify-content-center align-items-center flex-column" style="height:max-content;min-width:100px;">
                                        <img src="{{ asset('storage/kategori/') }}/{{ $kat->image }}" height="100" alt="">
                                        <div class="overlay position-absolute w-100 opacity-25 top-0 bottom-0 left-0 right-0 bg-dark"></div>
                                        <span class="position-absolute text-light text-shadow" style="z-index: 999999;">{{ $kat->name }}</span>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 mt-4">
                        <div class="card shadow-sm">
                            <div class="card-header d-flex justify-content-between align-items-center" style="background-color: rgb(107, 33, 245);">
                                <h4 class="m-0 text-white">Daftar Produk</h4>
                                <input type="search" class="form-control" style="width: 200px;" placeholder="Search...">
                            </div>
                            <div class="card-body p-4">
                                <div class="row">
                                    @foreach($produk as $p)
                                    <div class="col-lg-2 mb-3" style="max-height: 200px;">
                                        <div class="w-100 position-relative">
                                            <div class="w-100 d-flex justify-content-center align-items-center" style="height: 100px;overflow:hidden">
                                                <img src="{{ asset('storage/produk/') }}/{{ $p->image }}" alt="" width="100%">
                                            </div>
                                            <span class="d-block mt-2" id="nama_produk_{{ $p->barcode }}"><strong>{{ $p->name }}</strong></span>
                                            <span class="d-block" id="harga_{{ $p->barcode }}">@currency($p->harga)</span>
                                            <span class="d-block" id="stock_{{ $p->barcode }}">Stok: {{ $p->stok }}</span>
                                            <div class="row">
                                                <div class="col-6">
                                                    <button {{ $p->stok <= 0 ? 'disabled' : '' }} data-barcode-produk="{{ $p->barcode }}" class="btn btn-sm btn-primary button-add-cart mt-2 d-flex justify-content-center align-items-center w-100" title="Tambah"><i data-barcode-produk="{{ $p->barcode }}" class='bx bx-plus'></i></button>
                                                </div>
                                                <div class="col-6">
                                                    <button {{ $p->stok <= 0 ? 'disabled' : '' }} data-barcode-produk="{{ $p->barcode }}" class="btn btn-sm btn-primary button-deleted-cart mt-2 d-flex justify-content-center align-items-center w-100" title="Kurangi"><i data-barcode-produk="{{ $p->barcode }}" class='bx bx-minus'></i></button>
                                                </div>
                                            </div>
                                            <span id="jumlah_{{ $p->barcode }}" class="position-absolute jumlah-produk rounded-circle d-flex justify-content-center align-items-center" style="top:10px;right: 10px;background-color: red;width:20px;height:20px;font-size:0.6em;color:white;">0</span>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 p-4">
                <div class="card">
                    <div class="card-header">
                        <h4>Total Tagihan</h4>
                    </div>
                    <div class="card-body" id="list_produk">
                        
                    </div>
                    <div class="card-footer mt-4" id="total_harga">
                        
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-12">
                        <button onclick="addCart()" type="button" id="checkout_produk" class="btn w-100 btn-primary">Check Out</button>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

    <!-- Main JS -->
    <script>
        const btnAddCart = document.querySelectorAll('.button-add-cart');
        const btnDeletedCart = document.querySelectorAll('.button-deleted-cart');
    const __token = `{{ csrf_token() }}`;
    const totalCart = document.querySelector('#total-cart');
    document.addEventListener('DOMContentLoaded', () => {
        if(localStorage.getItem('carts') != null) {
            const carts = JSON.parse(localStorage.getItem('carts'));
            carts.forEach(cart => {
                updateCount(document.getElementById(`jumlah_${cart.barcode}`), cart.total)
            });
            document.dispatchEvent(new Event('render'));
        }
    })
    let datas;
    btnAddCart.forEach(element => {
        element.addEventListener('click', (e) => {
            if(e.target.tagName == 'BUTTON' || e.target.tagName == 'I') {
                const barcode = e.target.getAttribute('data-barcode-produk');
                saveCarts(barcode);
                document.dispatchEvent(new Event('render'));
            }
        })
    });
    btnDeletedCart.forEach(element => {
        element.addEventListener('click', (e) => {
            const carts = JSON.parse(localStorage.getItem('carts'));
            if(carts.length <= 0) {
                const totalProduk = document.getElementById('total_harga');
                totalProduk.innerHTML = '';
            }
            if(e.target.tagName == 'BUTTON' || e.target.tagName == 'I') {
                const barcode = e.target.getAttribute('data-barcode-produk');
                saveCarts(barcode, 'minus');
                document.dispatchEvent(new Event('render'));
            }
        })
    });
    // function renderCart(element) {
    //     document.addEventListener('render', function(event) {

    //     })
    // }
    function updateCount(element, count) {
        element.textContent = count;
    }
    function saveCarts(barcode, action = 'plus') {
        try {
            if(action == 'plus') {
                if(checkStorage('carts') == false) {
                    const dataCarts = [
                        {
                            nama_produk: document.getElementById(`nama_produk_${barcode}`).textContent,
                            harga: document.getElementById(`harga_${barcode}`).textContent,
                            barcode: barcode,
                            total: 1
                        }
                    ];
                    localStorage.setItem('carts', JSON.stringify(dataCarts));
                    updateCount(document.getElementById(`jumlah_${barcode}`), dataCarts[0].total)
                }else {
                    const carts = JSON.parse(localStorage.getItem('carts'));
                    // console.log(carts)
                    const cart = carts.filter(cart => cart.barcode == barcode)[0];
                    const newCart = {
                        nama_produk: document.getElementById(`nama_produk_${barcode}`).textContent,
                        harga: document.getElementById(`harga_${barcode}`).textContent,
                        barcode: barcode,
                        total: 1
                    };
                    if(cart == undefined) {
                        carts.push(newCart);
                    }else {
                        console.log(cart)
                        cart.total += 1;
                    }
                    updateCount(document.getElementById(`jumlah_${barcode}`), (cart == undefined) ? newCart.total : cart.total)
                    localStorage.setItem('carts', JSON.stringify(carts));
                }
            }else {
                const carts = JSON.parse(localStorage.getItem('carts'));

                const cart = carts.filter(cart => cart.barcode == barcode)[0];
                if(cart != undefined) {
                    cart.total -= 1;
                    if(carts.length > 0) {
                        const index = carts.indexOf(cart);
                        carts.splice(index, 1);
                        cart.total = 0;
                    }
                    document.dispatchEvent(new Event('render'));
                    updateCount(document.getElementById(`jumlah_${barcode}`), cart.total ? cart.total : 0)
                }
                localStorage.setItem('carts', JSON.stringify(carts));
            }
        } catch (error) {
            alert(`Terjadi Masalah : ${error}`)
            return false;
        }
    }
    function getAll(condition = {where: '', condition: ''}) {

    }
    function checkStorage(name) {
        if(localStorage.getItem(name) == null) {
            return false;
        }else {
            return true;
        }
    }
    function find(barcode) {
        if(localStorage.getItem('carts') == null) {
            return [];
        }else {
            const data = JSON.parse(localStorage.getItem('carts'));
            const result = data.filter(d => d.barcode == barcode);
            if(result.length > 0) {
                return result[0];
            }else {
                return [];
            }
        }
    }
    function addCart() {
        const dataForm = {
            carts: localStorage.getItem('carts')
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
                localStorage.setItem('carts', '[]');
                document.dispatchEvent(new Event('render'));
                window.location.reload();
            }
        })

    }
    document.addEventListener('render', function() {
        const carts = JSON.parse(localStorage.getItem('carts'));
        const listProduk = document.getElementById('list_produk');
        if(carts.length > 0) {
            render(listProduk, carts);
        }else {
            listProduk.innerHTML = '<div class="text-center">Tidak Ada Produk</div>'
        }
    })
    function render(element, data) {
        element.innerHTML = '';
        const totalProduk = document.getElementById('total_harga');
        renderTotal(totalProduk, data);
        data.forEach(d => {
            let total = d.harga.split('Rp');
                total = total[1].split('.');
                total = (total[0] + total[1])
                total = (d.total * total);
            const newTotal = formatRupiah(total, 'Rp');
            const row = document.createElement('div');
            row.style.borderBottom = '1px solid #797B7C'
            row.setAttribute('class', 'row py-2');
            row.innerHTML = `<div class="col-8">
                                <span class="me-2"><strong>${d.total}X</strong></span>
                                <span><strong>${d.nama_produk}</strong></span>
                            </div>
                            <div class="col-4 text-end">
                                ${newTotal}
                            </div>`;
            element.appendChild(row);
        })
    }
    function renderTotal(element, data) {
        const totalHarga = [];
        let count = 0;
        data.forEach(d => {
            let total = d.harga.split('Rp');
                total = total[1].split('.');
                total = (total[0] + total[1])
                total = (d.total * total);
                totalHarga.push(total);
        })
        for(let i = 0; i < totalHarga.length; i++) {
            count += parseInt(totalHarga[i]);
        }
        const totalAkhir = formatRupiah(count, 'Rp');
            element.innerHTML = `<div class="row">
                                <div class="col-8">
                                    Total :
                                </div>
                                <div class="col-4 text-end">
                                    ${totalAkhir}
                                </div>            
                            </div>`;
        
    }
    function updateJumlah(JumlahProduk, id) {
        fetch(`api/cart/jumlah/${id}`).then(response => response.json())
        .then(result => {
            if(result.jumlah > 0) {
                if(JumlahProduk.classList.contains('d-none')) {
                    JumlahProduk.classList.replace('d-none', 'd-flex');
                }
            }
            JumlahProduk.textContent = result.jumlah;
        });
        
    }
    function formatRupiah(angka, prefix){
        // console.log(angka.replace())
        var number_string = angka.toString().replace(/[^,\d]/g, ''),
        split   		= number_string.split(','),
        sisa     		= split[0].length % 3,
        rupiah     		= split[0].substr(0, sisa),
        ribuan     		= split[0].substr(sisa).match(/\d{3}/gi);

        // tambahkan titik jika yang di input sudah menjadi angka ribuan
        if(ribuan){
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
    }
    </script>
  </body>
</html>