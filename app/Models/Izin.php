<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Izin extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'jenis_izin',
        'alasan',
        'tanggal_mulai',
        'tanggal_selesai',
        'jam_izin_terlambat',
        'file_bukti',
        'status_approval',
        'approved_by',
        'catatan_admin',
        'approved_at',
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
        'jam_izin_terlambat' => 'datetime',
        'approved_at' => 'datetime',
    ];

    /**
     * RELASI: Izin milik User (pengaju)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * RELASI: Izin disetujui oleh Admin
     */
    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /**
     * SCOPE: Filter berdasarkan jenis izin
     */
    public function scopeJenis($query, $jenis)
    {
        return $query->where('jenis_izin', $jenis);
    }

    /**
     * SCOPE: Filter izin pending
     */
    public function scopePending($query)
    {
        return $query->where('status_approval', 'pending');
    }

    /**
     * METHOD: Cek apakah tanggal termasuk dalam periode izin
     */
    public function isTanggalDalamIzin($tanggal)
    {
        $tanggal = \Carbon\Carbon::parse($tanggal);
        $mulai = \Carbon\Carbon::parse($this->tanggal_mulai);
        $selesai = \Carbon\Carbon::parse($this->tanggal_selesai);
        
        return $tanggal->between($mulai, $selesai);
    }
}