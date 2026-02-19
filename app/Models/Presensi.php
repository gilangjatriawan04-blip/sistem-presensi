<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Presensi extends Model
{
    use HasFactory;

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

    protected $casts = [
        'tanggal' => 'date',
        'jam_masuk' => 'datetime',
        'jam_pulang' => 'datetime',
        'terlambat_menit' => 'integer',
        'pulang_cepat_menit' => 'integer',
        'total_kerja_menit' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function hitungStatus()
    {
        if (!$this->jam_masuk) {
            $this->status = 'alpha';
            return;
        }

        $jamMasuk = Carbon::parse($this->jam_masuk);
        $jamMasukNormal = Carbon::parse($this->jam_masuk_normal);
        
        if ($jamMasuk->greaterThan($jamMasukNormal)) {
            $this->terlambat_menit = $jamMasuk->diffInMinutes($jamMasukNormal);
            $this->status = 'terlambat';
        } else {
            $this->terlambat_menit = 0;
            $this->status = 'tepat_waktu';
        }

        if ($this->jam_pulang) {
            $jamPulang = Carbon::parse($this->jam_pulang);
            $jamPulangNormal = Carbon::parse($this->jam_pulang_normal);
            
            if ($jamPulang->lessThan($jamPulangNormal)) {
                $this->pulang_cepat_menit = $jamPulangNormal->diffInMinutes($jamPulang);
                $this->status = 'pulang_cepat';
            } else {
                $this->pulang_cepat_menit = 0;
            }
            
            $this->total_kerja_menit = $jamMasuk->diffInMinutes($jamPulang);
        }

        $this->save();
    }
}