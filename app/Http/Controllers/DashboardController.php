<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Presensi;
use App\Models\User;
use App\Models\Izin;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $today = Carbon::today()->format('Y-m-d');
        
        // Data umum untuk semua role
        $data = [
            'user' => $user,
            'today' => $today,
        ];
        
        // Dashboard berdasarkan role
        switch ($user->role) {
            case 'admin':
                return $this->adminDashboard($data);
            case 'pembimbing':
                return $this->pembimbingDashboard($data);
            default: // pegawai (peserta magang)
                return $this->pegawaiDashboard($data);
        }
    }
    
    private function adminDashboard($data)
    {
        // Statistik untuk admin
        $data['total_users'] = User::count();
        $data['total_presensi_hari_ini'] = Presensi::whereDate('tanggal', $data['today'])->count();
        $data['total_izin_pending'] = Izin::where('status_approval', 'pending')->count();
        $data['users_magang_aktif'] = User::where('start_date', '<=', $data['today'])
            ->where('end_date', '>=', $data['today'])
            ->count();
        
        // Presensi hari ini
        $data['presensi_hari_ini'] = Presensi::with('user')
            ->whereDate('tanggal', $data['today'])
            ->orderBy('jam_masuk', 'desc')
            ->limit(10)
            ->get();
        
        return view('dashboard.admin', $data);
    }
    
    private function pembimbingDashboard($data)
    {
        // Pembimbing melihat peserta bimbingannya
        // Untuk sekarang, anggap semua peserta magang
        $data['total_bimbingan'] = User::where('role', 'pegawai')->count();
        $data['presensi_hari_ini'] = Presensi::with('user')
            ->whereDate('tanggal', $data['today'])
            ->orderBy('jam_masuk', 'desc')
            ->limit(20)
            ->get();
        
        return view('dashboard.pembimbing', $data);
    }
    
    private function pegawaiDashboard($data)
    {
        $user = $data['user'];
        
        // Data presensi hari ini
        $data['presensi_hari_ini'] = Presensi::where('user_id', $user->id)
            ->whereDate('tanggal', $data['today'])
            ->first();
        
        // Data presensi bulan ini
        $data['presensi_bulan_ini'] = Presensi::where('user_id', $user->id)
            ->whereMonth('tanggal', Carbon::now()->month)
            ->orderBy('tanggal', 'desc')
            ->get();
        
        // Statistik
        $data['total_hadir'] = Presensi::where('user_id', $user->id)
            ->whereIn('status', ['tepat_waktu', 'terlambat'])
            ->count();
        
        $data['total_terlambat'] = Presensi::where('user_id', $user->id)
            ->where('status', 'terlambat')
            ->count();
        
        // Izin pending
        $data['izin_pending'] = Izin::where('user_id', $user->id)
            ->where('status_approval', 'pending')
            ->count();
        
        // Sisa hari magang
        if ($user->end_date) {
            $sisa = Carbon::parse($user->end_date)->diffInDays(Carbon::now());
            $data['sisa_hari_magang'] = max(0, $sisa);
        }
        
        return view('dashboard.pegawai', $data);
    }
}