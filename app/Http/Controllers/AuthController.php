<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Untuk proses login
use Illuminate\Support\Facades\Hash; // Untuk enkripsi password
use App\Models\User; // Panggil Model User

class AuthController extends Controller
{

    //========================================================
    // FUNGSI UNTUK MENAMPILKAN FORM LOGIN
    //========================================================
    /**
     * Menampilkan halaman form login.
     * Ini memperbaiki error 'showLogin undefined'.
     */
    public function showLogin()
    {
        // KITA UBAH JADI SIMPEL (Sesuai posisi file baru):
        return view('login-form');
    }

    //========================================================
    // FUNGSI UNTUK MEMPROSES LOGIN
    //========================================================
    /**
     * Memproses data dari form login.
     */
    public function login(Request $request)
    {
        // 1. Validasi input
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // 2. Coba lakukan login
        if (Auth::attempt($credentials)) {
            // Jika berhasil
            $request->session()->regenerate();

            // Simpan nama user di session untuk sapaan
            session(['username' => Auth::user()->name]);

            // Arahkan ke dashboard guest (Soal 3)
            return redirect()->intended(route('guest.dashboard'));
        }

        // 3. Jika gagal
        return back()->with('error', 'Login gagal! Email atau Password salah.');
    }

    //========================================================
    // FUNGSI UNTUK MENAMPILKAN FORM REGISTER
    // (Ini yang memperbaiki error 'showRegister undefined')
    //========================================================
    /**
     * Menampilkan halaman form registrasi.
     */
 public function showRegister()
    {

        return view('register-form');
    }

    //========================================================
    // FUNGSI UNTUK MEMPROSES REGISTER
    //========================================================
    /**
     * Memproses data dari form registrasi.
     */
    public function register(Request $request)
    {
        // 1. Validasi input (DIPERBARUI)
        $request->validate([
            'name' => 'required|string|max:255',

            // PERHATIKAN BAGIAN INI:
          
            'email' => 'required|string|email|max:255|unique:users',

            'password' => 'required|string|min:8|confirmed',
        ], [
            
            'email.unique' => 'Email ini sudah terdaftar! Silakan gunakan email lain atau login.',
            'email.required' => 'Email wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        // ... (sisa kode create user di bawah tetap sama) ...
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);
        return redirect()->route('guest.dashboard');
    }


    //========================================================
    // FUNGSI UNTUK LOGOUT
    //========================================================
    /**
     * Memproses logout user.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Arahkan ke halaman login lagi
        return redirect()->route('login');
    }
}
