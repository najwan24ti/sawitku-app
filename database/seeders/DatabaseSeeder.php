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
        // 1. BUAT USER UTAMA (Biar Anda gak capek register terus)
        $user = User::create([
            'name' => 'Gilang Juragan Sawit',
            'email' => 'gilang@sawitku.com',
            'password' => Hash::make('password123'), // Password default
        ]);

        // 2. BUAT 50 DATA DUMMY KEUANGAN (Biar Grafik Dashboard Cantik)
        $jenisTransaksi = ['pemasukan', 'pengeluaran'];
        $deskripsiMasuk = ['Jual TBS 2 Ton', 'Jual Brondolan', 'Panen Kavling A', 'Bonus Koperasi'];
        $deskripsiKeluar = ['Beli Pupuk Urea', 'Gaji Karyawan Panen', 'Beli Racun Rumput', 'Service Truk', 'Makan Siang'];

        for ($i = 0; $i < 50; $i++) {
            // Acak Jenis
            $jenis = $jenisTransaksi[array_rand($jenisTransaksi)];
            
            // Acak Deskripsi sesuai jenis
            $deskripsi = ($jenis == 'pemasukan') 
                ? $deskripsiMasuk[array_rand($deskripsiMasuk)] 
                : $deskripsiKeluar[array_rand($deskripsiKeluar)];

            // Acak Nominal (Pemasukan lebih besar biar untung)
            $nominal = ($jenis == 'pemasukan') 
                ? rand(1000000, 5000000) 
                : rand(50000, 500000);

            // Acak Tanggal (Mundur ke belakang sampai 30 hari lalu)
            $tanggal = Carbon::now()->subDays(rand(0, 30));

            CatatanKeuangan::create([
                'user_id'   => $user->id,
                'tanggal'   => $tanggal,
                'deskripsi' => $deskripsi,
                'jenis'     => $jenis,
                'nominal'   => $nominal,
                'bukti'     => null, // Kosongkan dulu
            ]);
        }
    }
}