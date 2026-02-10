<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Role sistem - pakai string karena enum tidak support di semua DB
            $table->string('role')->default('pegawai');
            
            // Data Magang
            $table->string('jenis_peserta')->nullable();
            $table->string('institution_name')->nullable();
            $table->string('institution_class')->nullable();
            $table->string('nim_nisn', 50)->nullable();
            $table->string('supervisor_name')->nullable();
            $table->string('supervisor_contact', 20)->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            
            // Keamanan Multi Login
            $table->string('device_id')->nullable();
            $table->timestamp('last_login_at')->nullable();
            $table->string('last_login_ip', 45)->nullable();
        });

        // Set constraint untuk role menggunakan raw SQL (optional)
        // DB::statement("ALTER TABLE users ADD CONSTRAINT chk_role CHECK (role IN ('admin', 'pegawai', 'pembimbing'))");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'role',
                'jenis_peserta',
                'institution_name',
                'institution_class',
                'nim_nisn',
                'supervisor_name',
                'supervisor_contact',
                'start_date',
                'end_date',
                'device_id',
                'last_login_at',
                'last_login_ip',
            ]);
        });
    }
};