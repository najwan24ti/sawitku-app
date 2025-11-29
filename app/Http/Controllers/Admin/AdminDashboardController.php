<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\CatatanKeuangan;
use App\Models\Event; // Pastikan Model Event dipanggil

class AdminDashboardController extends Controller
{
    public function index()
    {
        // --- 1. RINGKASAN JUMLAH ---
        $totalPetani = User::where('role', 'petani')->count();
        $totalMitra  = User::where('role', 'mitra')->count();
        $totalEvent  = Event::count(); // Menghitung total event
        $totalCatatan = CatatanKeuangan::count(); // Total transaksi

        // --- 2. RINGKASAN NILAI KEUANGAN (SEMUA PETANI) ---
        $totalPemasukan = CatatanKeuangan::where('jenis', 'pemasukan')->sum('nominal');
        $totalPengeluaran = CatatanKeuangan::where('jenis', 'pengeluaran')->sum('nominal');

        // --- 3. TABEL RINGKAS (DATA TERBARU) ---
        // Ambil 5 transaksi terakhir lengkap dengan nama user-nya
        $transaksiTerbaru = CatatanKeuangan::with('user')->latest()->take(5)->get();
        
        // Ambil 5 event terbaru lengkap dengan nama mitra-nya
        $eventTerbaru = Event::with('user')->latest()->take(5)->get();

        return view('pages.admin.dashboard', compact(
            'totalPetani', 
            'totalMitra', 
            'totalEvent',
            'totalCatatan',
            'totalPemasukan', 
            'totalPengeluaran',
            'transaksiTerbaru',
            'eventTerbaru'
        ));
    }
}