<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'avatar',
        'password',
        'role',
        'jenis_peserta',
        'institution_name',
        'institution_class',
        'nim_nisn',
        'supervisor_name',
        'supervisor_contact',
        'start_date',
        'end_date',
         'catatan_pembimbing',
        'device_id',
        'last_login_at',
        'last_login_ip',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'start_date' => 'date',
            'end_date' => 'date',
            'last_login_at' => 'datetime',
        ];
    }

    public function presensis()
    {
        return $this->hasMany(Presensi::class);
    }

    public function izins()
    {
        return $this->hasMany(Izin::class);
    }

    public function approvedIzins()
    {
        return $this->hasMany(Izin::class, 'approved_by');
    }

    public function getAvatarUrlAttribute()
    {
        return $this->avatar ? asset('storage/' . $this->avatar) : null;
    }
}