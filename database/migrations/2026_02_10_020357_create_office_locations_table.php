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
        Schema::create('office_locations', function (Blueprint $table) {
            $table->id();
            $table->string('nama_lokasi');
            $table->text('alamat')->nullable();
            
            // Koordinat GPS (Poin 7)
            $table->decimal('latitude', 10, 8);  // Contoh: -6.1753924
            $table->decimal('longitude', 11, 8); // Contoh: 106.8271528
            
            // Radius dalam meter
            $table->integer('radius_meter')->default(100);
            
            // Jam kerja default lokasi ini
            $table->time('jam_masuk_default')->default('08:00:00');
            $table->time('jam_pulang_default')->default('17:00:00');
            
            $table->boolean('is_aktif')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('office_locations');
    }
};