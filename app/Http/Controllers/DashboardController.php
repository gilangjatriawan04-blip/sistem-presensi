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
        
        // ===== PERBAIKAN: HANYA PESERTA YANG DI-REDIRECT =====
        if ($user->role === 'peserta' && empty($user->jenis_peserta)) {
            return redirect()->route('profile.edit')
                ->with('warning', 'Silakan lengkapi profile Anda terlebih dahulu.');
        }
        // ===== END PERBAIKAN =====
        
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
            default: // peserta
                return $this->pesertaDashboard($data);
        }
    }
    
   private function adminDashboard($data)
{
    $today = $data['today'];
    
    // Statistik dasar
    $data['total_users'] = User::count();
    $data['total_presensi_hari_ini'] = Presensi::whereDate('tanggal', $today)->count();
    $data['total_izin_pending'] = Izin::where('status_approval', 'pending')->count();
    $data['users_magang_aktif'] = User::where('role', 'peserta')
        ->whereDate('start_date', '<=', $today)
        ->whereDate('end_date', '>=', $today)
        ->count();
    
    // Grafik 7 hari terakhir
    $chartData = [];
    $chartLabels = [];
    for ($i = 6; $i >= 0; $i--) {
        $date = Carbon::today()->subDays($i);
        $chartLabels[] = $date->format('d/m');
        $chartData[] = Presensi::whereDate('tanggal', $date->format('Y-m-d'))->count();
    }
    $data['chartLabels'] = $chartLabels;
    $data['chartData'] = $chartData;
    
    // Statistik izin per jenis
    $data['izin_stats'] = [
        'izin' => Izin::where('jenis_izin', 'izin')->count(),
        'sakit' => Izin::where('jenis_izin', 'sakit')->count(),
        'izin_terlambat' => Izin::where('jenis_izin', 'izin_terlambat')->count(),
        'tugas_luar' => Izin::where('jenis_izin', 'tugas_luar')->count(),
    ];
    
    // 5 peserta dengan kehadiran terbanyak
    $data['peserta_terbaik'] = User::where('role', 'peserta')
        ->withCount('presensis')
        ->orderBy('presensis_count', 'desc')
        ->limit(5)
        ->get();
    
    // Presensi hari ini
    $data['presensi_hari_ini'] = Presensi::with('user')
        ->whereDate('tanggal', $today)
        ->orderBy('jam_masuk', 'desc')
        ->limit(10)
        ->get();
    
    return view('dashboard.admin', $data);
}
    
   private function pembimbingDashboard($data)
{
    // Statistik
    $data['total_bimbingan'] = User::where('role', 'peserta')->count();
    $data['presensi_hari_ini'] = Presensi::with('user')
        ->whereDate('tanggal', $data['today'])
        ->orderBy('jam_masuk', 'desc')
        ->limit(20)
        ->get();
    
    // Peserta terbaru (5 orang)
    $data['pesertaTerbaru'] = User::where('role', 'peserta')
        ->orderBy('created_at', 'desc')
        ->limit(5)
        ->get();
    
    // Grafik 7 hari
    $chartData = [];
    $chartLabels = [];
    for ($i = 6; $i >= 0; $i--) {
        $date = Carbon::today()->subDays($i);
        $chartLabels[] = $date->format('d/m');
        $chartData[] = Presensi::whereDate('tanggal', $date->format('Y-m-d'))->count();
    }
    $data['chartLabels'] = $chartLabels;
    $data['chartData'] = $chartData;
    
    return view('dashboard.pembimbing', $data);
}
    
    private function pesertaDashboard($data)
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
        
        return view('dashboard.peserta', $data);
    }
}