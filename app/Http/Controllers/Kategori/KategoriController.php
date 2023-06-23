<?php

namespace App\Http\Controllers\Kategori;

use App\Models\Kategori;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('kategori.index', [
            'title' => 'Kategori',
            'active' => 'kategori',
            'kategori' => Kategori::where('deleted_at', null)->latest()->paginate(10)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $validate = Validator::make($request->all(), [
            'name' => 'required'
        ]);
        // dd($validate->fails());
        if ($validate->fails()) {
            Alert::error('Gagal', 'Kategori Gagal Ditambah, Harap Priksa Inputan Anda!');
            return redirect()->back();
        }

        $image = '';
        $mimes = ['image/jpeg', 'image/png', 'image/jpg', 'image/svg'];
        if ($request->hasFile('image')) {
            foreach ($mimes as $index => $mime) {
                if ($request->file('image')->getMimeType() !== $mimes[$index]) {
                    Alert::error('Gagal', 'Format Gambar Tidak Sesuai, Harap Upload Gambar Dengan Format jpg, jpeg, png dan svg!');
                    return redirect()->back();
                } else {
                    $file = $request->file('image');
                    $ext = $file->getClientOriginalExtension();
                    $newName = Str::random(32) . '.' . $ext;
                    $file->storeAs('/public/kategori', $newName);
                    $image = $newName;
                    Kategori::create([
                        'image' => $image,
                        'name' => $request->name
                    ]);
                    Alert::success('Suksess', 'Kategori Berhasil Ditambahkan!');
                    return redirect()->back();
                }
            }
        } else {
            Alert::error('Gagal', 'Gambar Harus Di Isi!');
            return redirect()->back();
        }
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
        $request->validate([
            'image' => 'mimes:jpg,jpeg,png,svg|image',
            'name' => 'required'
        ]);
        $kategori = Kategori::find($id);
        $mimes = ['image/jpeg', 'image/png', 'image/jpg', 'image/svg'];
        if ($request->hasFile('image')) {
            Storage::delete('/public/kategori/' . $kategori->image);
            $file = $request->file('image');
            $ext = $file->getClientOriginalExtension();
            $newName = Str::random(32) . '.' . $ext;
            $file->storeAs('/public/kategori', $newName);
            $kategori->image = $newName;
        }
        Alert::success('Suksess', 'Kategori Berhasil Diupdate!');
        $kategori->name = $request->name;
        $kategori->save();

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $kategori = Kategori::find($id);
        $kategori->deleted_at = Carbon::now();
        $kategori->save();

        Alert::success('Suksess', 'Kategori Berhasil Dihapus!');

        return redirect()->back();
    }
}
