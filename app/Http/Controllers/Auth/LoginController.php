<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class LoginController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }
    public function authenticate(Request $request)
    {
        $validate = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        if (Auth::attempt($validate)) {
            $request->session()->regenerate();
            Alert::success('Suksess', 'Hai, Selamat Datang!');
            if (Auth::user()->role->name !== 'admin') {
                return redirect()->intended('/dashboard-kasir');
            } else {
                return redirect()->intended('/dashboard');
            }
        }

        Alert::error('Gagal', 'Login Gagal, Pastikan Anda Sudah Memiliki Akun!');
        return redirect()->back();
    }
    public function logout()
    {
        Auth::logout();
        request()->session()->invalidate();

        request()->session()->regenerateToken();

        return redirect(url('/'));
    }
}
