<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfficeLocation extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_lokasi',
        'alamat',
        'latitude',
        'longitude',
        'radius_meter',
        'jam_masuk_default',
        'jam_pulang_default',
        'is_aktif',
    ];

    protected $casts = [
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'radius_meter' => 'integer',
        'is_aktif' => 'boolean',
        'jam_masuk_default' => 'datetime:H:i',
        'jam_pulang_default' => 'datetime:H:i',
    ];

    /**
     * SCOPE: Hanya lokasi aktif
     */
    public function scopeAktif($query)
    {
        return $query->where('is_aktif', true);
    }

    /**
     * METHOD: Format koordinat untuk Google Maps
     */
    public function getKoordinatAttribute()
    {
        return $this->latitude . ', ' . $this->longitude;
    }

    /**
     * METHOD: Validasi apakah koordinat dalam radius
     */
    public function isDalamRadius($latitude, $longitude)
    {
        // Implementasi rumus Haversine sama seperti di Presensi
        // Bisa dipindah ke helper class nanti
        
        $earthRadius = 6371000;
        
        $latFrom = deg2rad($latitude);
        $lonFrom = deg2rad($longitude);
        $latTo = deg2rad($this->latitude);
        $lonTo = deg2rad($this->longitude);
        
        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;
        
        $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
            cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));
        
        $distance = $angle * $earthRadius;
        
        return $distance <= $this->radius_meter;
    }
}