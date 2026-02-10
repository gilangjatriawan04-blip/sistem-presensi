<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Presensi extends Model
{
    use HasFactory;

    /**
     * Kolom yang bisa diisi massal
     */
    protected $fillable = [
        'user_id',
        'tanggal',
        'jam_masuk',
        'jam_pulang',
        'lokasi_masuk',
        'lokasi_pulang',
        'status',
        'keterangan',
        'jam_masuk_normal',
        'jam_pulang_normal',
        'terlambat_menit',
        'pulang_cepat_menit',
        'total_kerja_menit',
    ];

    /**
     * Tipe data casting
     */
    protected $casts = [
        'tanggal' => 'date',
        'jam_masuk' => 'datetime',
        'jam_pulang' => 'datetime',
        'terlambat_menit' => 'integer',
        'pulang_cepat_menit' => 'integer',
        'total_kerja_menit' => 'integer',
    ];

    /**
     * RELASI: Presensi milik seorang User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * METHOD: Hitung status presensi
     */
    public function hitungStatus()
    {
        if (!$this->jam_masuk) {
            $this->status = 'alpha';
            return;
        }

        $jamMasuk = \Carbon\Carbon::parse($this->jam_masuk);
        $jamMasukNormal = \Carbon\Carbon::parse($this->jam_masuk_normal);
        
        // Hitung keterlambatan
        if ($jamMasuk->greaterThan($jamMasukNormal)) {
            $this->terlambat_menit = $jamMasuk->diffInMinutes($jamMasukNormal);
            $this->status = 'terlambat';
        } else {
            $this->terlambat_menit = 0;
            $this->status = 'tepat_waktu';
        }

        // Hitung pulang cepat jika sudah pulang
        if ($this->jam_pulang) {
            $jamPulang = \Carbon\Carbon::parse($this->jam_pulang);
            $jamPulangNormal = \Carbon\Carbon::parse($this->jam_pulang_normal);
            
            if ($jamPulang->lessThan($jamPulangNormal)) {
                $this->pulang_cepat_menit = $jamPulangNormal->diffInMinutes($jamPulang);
            } else {
                $this->pulang_cepat_menit = 0;
            }
            
            // Hitung total jam kerja
            $this->total_kerja_menit = $jamMasuk->diffInMinutes($jamPulang);
        }

        $this->save();
    }

    /**
     * METHOD: Validasi lokasi GPS
     */
    public function validasiLokasi($latitude, $longitude, $officeLocation)
    {
        // Rumus Haversine untuk hitung jarak
        $earthRadius = 6371000; // Meter
        
        $latFrom = deg2rad($latitude);
        $lonFrom = deg2rad($longitude);
        $latTo = deg2rad($officeLocation->latitude);
        $lonTo = deg2rad($officeLocation->longitude);
        
        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;
        
        $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
            cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));
        
        $distance = $angle * $earthRadius;
        
        return $distance <= $officeLocation->radius_meter;
    }
}