<?php

namespace App\Http\Controllers\Produk;

use App\BarangMasuk\CreateBarangMasuk;
use App\Models\Produk;
use App\Models\Kategori;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('produk.index', [
            'title' => 'Produk',
            'active' => 'produk',
            'produk' => Produk::latest()->where('deleted_at', null)->paginate(10)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('produk.create', [
            'title' => 'Tambah Produk',
            'active' => 'produk',
            'kategori' => Kategori::all()->where('deleted_at', null)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'kategori' => 'required',
            'harga' => 'required',
            'satuan' => 'required',
        ]);
        $mimes = ['image/jpeg', 'image/png', 'image/jpg', 'image/svg'];
        $mime = $request->file('image')->getMimeType();
        if ($request->hasFile('image')) {
            if (!array_search($mime, $mimes)) {
                Alert::error('Gagal', 'Format Gambar Tidak Sesuai, Harap Upload Gambar Dengan Format jpg, jpeg, png dan svg!');
                return redirect()->back();
            } else {
                $file = $request->file('image');
                $ext = $file->getClientOriginalExtension();
                $newName = Str::random(32) . '.' . $ext;
                $file->storeAs('public/produk', $newName);

                $produk = Produk::create([
                    'image' => $newName,
                    'name' => $request->name,
                    'barcode' => random_int(100000000, 999999999),
                    'kategori_id' => $request->kategori,
                    'harga' => $request->harga,
                    'satuan' => $request->satuan,
                ]);
                Alert::success('Sukses', 'Produk Berhasil Di Tambah!');

                return redirect()->route('produk.index');
            }
        } else {
            Alert::error('Gagal', 'Produk Gagal Di Tambah! Gambar Harus Di Isi.');
        }

        Alert::error('Gagal', 'Produk Gagal Di Tambah! Periksa Inputan Anda.');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $produk = Produk::find($id);

        return view('produk.edit', [
            'title' => 'Edit Produk',
            'active' => 'produk',
            'produk' => $produk,
            'kategori' => Kategori::where('deleted_at', null)->get()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        if (isset($request->stok)) {
            $produk = Produk::find($id);
            $produk->stok = intval($produk->stok) + intval($request->stok);
            $produk->save();
            $barang_masuk = new CreateBarangMasuk();
            $barang_masuk->create($produk, $request->stok);
            Alert::success('Sukses', 'Stok Berhasil Ditambah!');
            return redirect()->route('produk.index');
        } else {
            $request->validate([
                'image' => 'mimes:jpg,jpeg,svg,png|image',
                'name' => 'required',
                'harga' => 'required',
                'satuan' => 'required',
            ]);

            $produk = Produk::find($id);
            if (isset($request->kategori)) {
                $produk->kategori_id = $request->kategori;
            }
            $produk->name = $request->name;
            $produk->harga = $request->harga;
            $produk->satuan = $request->satuan;
            // if ($produk->stok < $request->stok) {
            //     $barang_masuk = new CreateBarangMasuk();
            //     $barang_masuk->create($produk, ($request->stok - $produk->stok));
            // }
            if ($request->hasFile('image')) {
                Storage::delete('public/produk/' . $produk->image);
                $file = $request->file('image');
                $ext = $file->getClientOriginalExtension();
                $newName = Str::random(32) . '.' . $ext;
                $file->storeAs('public/produk', $newName);
                $produk->image = $newName;
            }
            $produk->save();

            Alert::success('Sukses', 'Produk Berhasil Di Update!');
            return redirect()->route('produk.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $produk = Produk::find($id);

        $produk->deleted_at = Carbon::now();
        $produk->save();

        Alert::success('Sukses', 'Produk Berhasil Di Hapus!');

        return redirect()->back();
    }
}
