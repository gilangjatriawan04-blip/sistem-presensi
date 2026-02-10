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
        Schema::create('presensis', function (Blueprint $table) {
            $table->id();
            
            // Foreign key ke user
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            
            // Tanggal presensi
            $table->date('tanggal');
            
            // Waktu presensi (Poin 6: waktu server)
            $table->timestamp('jam_masuk')->nullable();
            $table->timestamp('jam_pulang')->nullable();
            
            // Lokasi GPS (Poin 7)
            $table->string('lokasi_masuk')->nullable(); // Format: "lat,long"
            $table->string('lokasi_pulang')->nullable();
            
            // Status (Poin 9)
            $table->enum('status', [
                'tepat_waktu', 
                'terlambat', 
                'pulang_cepat', 
                'izin', 
                'sakit', 
                'tugas_luar',
                'alpha'
            ])->default('tepat_waktu');
            
            // Keterangan opsional
            $table->text('keterangan')->nullable();
            
            // Jam kerja normal (bisa dari office_hours table nanti)
            $table->time('jam_masuk_normal')->default('08:00:00');
            $table->time('jam_pulang_normal')->default('17:00:00');
            
            // Hitungan waktu
            $table->integer('terlambat_menit')->default(0);
            $table->integer('pulang_cepat_menit')->default(0);
            $table->integer('total_kerja_menit')->default(0);
            
            $table->timestamps();
            
            // Unique constraint: 1 user hanya 1 presensi per hari
            $table->unique(['user_id', 'tanggal']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('presensis');
    }
};