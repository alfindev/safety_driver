<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// TAMBAHKAN 3 BARIS INI:
use App\Models\User;          // Untuk memanggil Model User
use Illuminate\Support\Facades\Hash; // Untuk mengecek password
use Illuminate\Support\Facades\Session; // Untuk mengelola Session (opsional)

class AuthController extends Controller
{
    public function showLogin()
    {
        // Menggunakan helper session() atau Session::has()
        if (Session::has('user_id')) return redirect()->route('dashboard');
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        // Sekarang class User dikenali karena sudah di-import di atas
        $user = User::where('username', $request->username)->first();

        // Menggunakan Hash::check untuk memverifikasi password
        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->withErrors(['username' => 'Username atau password salah.']);
        }

        // Simpan ke session
        Session::put([
            'user_id'   => $user->id,
            'user_name' => $user->name,
            'user_role' => $user->role,
        ]);

        return redirect()->route('dashboard');
    }

    public function logout(Request $request)
    {
        // Menggunakan Session::flush() lebih disarankan di controller
        Session::flush();
        return redirect()->route('login');
    }
}