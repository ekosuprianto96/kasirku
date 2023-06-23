<?php

namespace App\Http\Controllers\Kasir;

use App\Models\User;
use App\Models\Kasir;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class KasirController extends Controller
{
    public function index()
    {
        return view('kasir.index', [
            'title' => 'Daftar Kasir',
            'active' => 'kasir',
            'kasir' => Kasir::whereNull('deleted_at')->paginate(10)
        ]);
    }
    public function create()
    {
        return view('kasir.create', [
            'title' => 'Tambah Kasir',
            'active' => 'kasir'
        ]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3',
            'alamat' => 'required',
            'no_telpon' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6'
        ]);
        $image = null;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $ext = $file->getClientOriginalExtension();
            $name = Str::random(32) . $ext;
            $file->storeAs('public/image_profile', $name);
            $image = $name;
        }

        $user = User::create([
            'role_id' => 2,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);
        Kasir::create([
            'user_id' => $user->id,
            'id_kasir' => mt_rand(10, 99) . mt_rand(1000, 9999) . mt_rand(1, 9),
            'image' => $image,
            'nama' => $user->name,
            'alamat' => $request->alamat,
            'no_telpon' => $request->no_telpon,
            'email' => $user->email
        ]);
        Alert::success('Suksess', 'Berhasil Registrasi Kasir!');
        return redirect()->route('kasir');
    }
    public function edit($id)
    {
        $kasir = Kasir::find($id);

        return view('kasir.edit', [
            'title' => 'Edit Kasir',
            'active' => 'kasir',
            'kasir' => $kasir
        ]);
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'image' => 'mimes:jpg,jpeg,png,svg|image',
            'name' => 'required|min:3',
            'alamat' => 'required',
            'no_telpon' => 'required',
            'email' => 'required|email',
        ]);

        $kasir = Kasir::find($id);

        if ($request->hasFile('image')) {
            Storage::delete('public/image_profile/' . $kasir->image);
            $file = $request->file('image');
            $ext = $file->getClientOriginalExtension();
            $name = Str::random(32) . '.' . $ext;
            $file->storeAs('public/image_profile', $name);
            $kasir->image = $name;
        }
        $user = User::find($kasir->user_id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        $kasir->nama = $user->name;
        $kasir->alamat = $request->alamat;
        $kasir->email = $user->email;
        $kasir->no_telpon = $request->no_telpon;
        $kasir->save();

        if ($kasir->save()) {
            Alert::success('Suksess', 'Berhasil Update Kasir!');
        } else {
            Alert::error('Gagal!', 'Gagal Update Kasir!, Silahkan Coba Lagi dan Pastikan Inputan Anda Sudah Benar.');
        }

        return redirect()->route('kasir');
    }
    public function destroy($id)
    {
        $kasir = Kasir::find($id);
        $kasir->deleted_at = Carbon::now()->toDateTimeString();
        $kasir->save();

        Alert::success('Suksess', 'Kasir Berhasil Dihapus!');

        return redirect()->back();
    }
}
