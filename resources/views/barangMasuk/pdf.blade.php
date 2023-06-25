<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"> --}}
    <style>
      th, tr, td {
        border: 1px solid black;
        white-space: nowrap;
        padding: 10px;
        font-size: 0.8em;
      }
      table {
        border-collapse: collapse;
        width: 100%;
        
      }
    </style>
    <title>Laporan Data Penjualan Tahun {{ \Carbon\carbon::now()->format('Y-m-d') }}</title>
  </head>
  <body>
    <h3 style="font-size: 1em;">Laporan Data Penjualan Tahun {{ \Carbon\carbon::now()->format('Y-m-d') }}</h3>
    <table>
      <thead>
        <tr>
          <th>No</th>
          <th>Barcode Produk</th>
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
          <td>{{ $index + 1 }}</td>
          <td>{{ $b->produk->barcode }}</td>
          <td><strong>{{ $b->nama_produk }}</strong></td>
          <td>{{ $b->produk->kategori->name }}</td>
          <td>{{ $b->jumlah }}</td>
          <td>@currency($b->produk->harga)</td>
          <td>{{ $b->satuan }}</td>
          <td class="text-center">{{ $b->created_at->format('d/M/Y') }}</td>
        </tr>
        @endforeach
      </tbody>
      <tfoot>
        <tr>
          <td colspan="5" style="text-align: center;">Total :</td>
          <td colspan="4" style="text-align: center;">{{ $barang->sum('jumlah') }}</td>
        </tr>
      </tfoot>
    </table>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    -->
  </body>
</html>