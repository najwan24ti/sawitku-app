<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CatatanKeuangan;
use Illuminate\Support\Facades\Auth; // <--- PENTING: Panggil Auth untuk tahu siapa yang login

class DashboardController extends Controller
{
    public function index()
    {
        // 1. AMBIL ID USER YANG SEDANG LOGIN
        // Kalau Ahmad login (ID 1), maka $userId = 1
        // Kalau Devi login (ID 2), maka $userId = 2
        $userId = Auth::id();

        // 2. HITUNG PEMASUKAN (Hanya milik user ini)
        $totalPemasukan = CatatanKeuangan::where('user_id', $userId) // <--- KUNCI PRIVASI
                            ->where('jenis', 'pemasukan')
                            ->sum('nominal');

        // 3. HITUNG PENGELUARAN (Hanya milik user ini)
        $totalPengeluaran = CatatanKeuangan::where('user_id', $userId) // <--- KUNCI PRIVASI
                            ->where('jenis', 'pengeluaran')
                            ->sum('nominal');

        // 4. HITUNG SALDO
        $saldoAkhir = $totalPemasukan - $totalPengeluaran;

        // 5. AMBIL 5 RIWAYAT TERAKHIR (Hanya milik user ini)
        $riwayatTerakhir = CatatanKeuangan::where('user_id', $userId) // <--- KUNCI PRIVASI
                            ->orderBy('tanggal', 'desc')
                            ->limit(5)
                            ->get();

        return view('pages.guest.dashboard', [
            'totalPemasukan' => $totalPemasukan,
            'totalPengeluaran' => $totalPengeluaran,
            'saldoAkhir' => $saldoAkhir,
            'riwayatTerakhir' => $riwayatTerakhir
        ]);
    }
}