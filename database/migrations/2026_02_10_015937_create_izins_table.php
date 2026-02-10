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
        Schema::create('izins', function (Blueprint $table) {
            $table->id();
            
            // Foreign key ke user yang mengajukan
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            
            // Jenis izin (Poin 8, 10, 11)
            $table->enum('jenis_izin', [
                'izin', 
                'sakit', 
                'izin_terlambat', 
                'tugas_luar'
            ]);
            
            // Deskripsi izin
            $table->text('alasan');
            
            // Periode izin (bisa multi hari)
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            
            // Khusus izin terlambat (Poin 10)
            $table->time('jam_izin_terlambat')->nullable();
            
            // File bukti (surat dokter, dll)
            $table->string('file_bukti')->nullable();
            
            // Approval system
            $table->enum('status_approval', [
                'pending', 
                'disetujui', 
                'ditolak'
            ])->default('pending');
            
            // Disetujui oleh admin
            $table->foreignId('approved_by')->nullable()->constrained('users');
            $table->text('catatan_admin')->nullable();
            $table->timestamp('approved_at')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('izins');
    }
};