<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('catatan_keuangans', function (Blueprint $table) {
            $table->id(); 

            // === BAGIAN INI SANGAT PENTING ===
            // Tanda // sudah saya hapus. Ini kuncinya agar data terhubung ke User.
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); 
            // =================================

            $table->date('tanggal'); 
            $table->string('deskripsi'); 
            $table->enum('jenis', ['pemasukan', 'pengeluaran']); 
            $table->decimal('nominal', 15, 2); 
            $table->string('bukti')->nullable();

            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('catatan_keuangans');
    }
};
