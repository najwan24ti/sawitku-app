<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\CatatanKeuangan;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. BUAT AKUN ADMIN (Super User)
        User::create([
            'name' => 'Administrator Sawit',
            'email' => 'admin@sawitku.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',   // Kuncinya disini
            'status' => 'aktif',
        ]);

        // 2. BUAT AKUN PETANI (Anda)
        $petani = User::create([
            'name' => 'Gilang Juragan',
            'email' => 'gilang@sawitku.com',
            'password' => Hash::make('password123'),
            'role' => 'petani',
            'status' => 'aktif',
        ]);

        // 3. BUAT DATA DUMMY KEUANGAN (Agar Dashboard Admin Ramai)
        // Kita buat 50 transaksi milik petani Gilang
        for ($i = 0; $i < 50; $i++) {
            $jenis = rand(0, 1) ? 'pemasukan' : 'pengeluaran';
            CatatanKeuangan::create([
                'user_id'   => $petani->id,
                'tanggal'   => Carbon::now()->subDays(rand(0, 30)),
                'deskripsi' => $jenis == 'pemasukan' ? 'Panen Sawit' : 'Beli Pupuk',
                'jenis'     => $jenis,
                'nominal'   => rand(100000, 5000000),
                'bukti'     => null,
            ]);
        }
    }
}