<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Presensi;
use App\Models\Izin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PembimbingController extends Controller
{
    /**
     * ============================================
     * DASHBOARD PEMBIMBING
     * ============================================
     * URL: /pembimbing/dashboard
     * Method: GET
     * View: pembimbing.dashboard
     */
   public function dashboard()
{
    $user = Auth::user();
    $today = Carbon::today()->format('Y-m-d');
    
    // Statistik
    $totalPeserta = User::where('role', 'peserta')->count();
    $presensiHariIni = Presensi::whereDate('tanggal', $today)->count();
    $izinPending = Izin::where('status_approval', 'pending')->count();
    $pesertaAktif = User::where('role', 'peserta')
        ->whereDate('start_date', '<=', $today)
        ->whereDate('end_date', '>=', $today)
        ->count();
    
    // Ambil 5 peserta terbaru
    $pesertaTerbaru = User::where('role', 'peserta')
                          ->orderBy('created_at', 'desc')
                          ->limit(5)
                          ->get();
    
    // Grafik presensi 7 hari terakhir
    $chartData = [];
    $chartLabels = [];
    for ($i = 6; $i >= 0; $i--) {
        $date = Carbon::today()->subDays($i);
        $chartLabels[] = $date->format('d/m');
        $chartData[] = Presensi::whereDate('tanggal', $date->format('Y-m-d'))->count();
    }
    
    return view('pembimbing.dashboard', compact(
        'totalPeserta',
        'presensiHariIni',
        'izinPending',
        'pesertaAktif',
        'chartLabels',
        'chartData',
        'pesertaTerbaru'
    ));
}
    
    /**
     * ============================================
     * DAFTAR PESERTA BIMBINGAN
     * ============================================
     * URL: /pembimbing/peserta
     * Method: GET
     * View: pembimbing.peserta
     */
    public function peserta(Request $request)
    {
        $search = $request->get('search', '');
        
        $peserta = User::where('role', 'peserta')
            ->when($search, function($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%")
                      ->orWhere('institution_name', 'like', "%{$search}%");
            })
            ->orderBy('name')
            ->paginate(20);
        
        return view('pembimbing.peserta', compact('peserta', 'search'));
    }
    
    /**
     * ============================================
     * DETAIL PRESENSI PESERTA
     * ============================================
     * URL: /pembimbing/peserta/{id}
     * Method: GET
     * View: pembimbing.detail-peserta
     */
    public function detailPeserta($id)
    {
        $peserta = User::findOrFail($id);
        
        // Ambil presensi 30 hari terakhir
        $presensis = Presensi::where('user_id', $id)
            ->whereDate('tanggal', '>=', Carbon::now()->subDays(30))
            ->orderBy('tanggal', 'desc')
            ->get();
        
        // Statistik peserta
        $totalHadir = Presensi::where('user_id', $id)
            ->whereIn('status', ['tepat_waktu', 'terlambat'])
            ->count();
        
        $totalTerlambat = Presensi::where('user_id', $id)
            ->where('status', 'terlambat')
            ->count();
        
        $totalIzin = Izin::where('user_id', $id)
            ->where('status_approval', 'disetujui')
            ->count();
        
        return view('pembimbing.detail-peserta', compact(
            'peserta',
            'presensis',
            'totalHadir',
            'totalTerlambat',
            'totalIzin'
        ));
    }
    
    /**
     * ============================================
     * MONITORING IZIN PESERTA
     * ============================================
     * URL: /pembimbing/izin
     * Method: GET
     * View: pembimbing.izin
     */
    public function izin(Request $request)
    {
        $status = $request->get('status', 'pending');
        
        $izins = Izin::with('user')
            ->when($status != 'all', function($query) use ($status) {
                $query->where('status_approval', $status);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(20);
        
        return view('pembimbing.izin', compact('izins', 'status'));
    }

    public function updateCatatan(Request $request, $id)
{
    $peserta = User::findOrFail($id);
    
    $request->validate([
        'catatan_pembimbing' => 'nullable|string|max:1000',
    ]);
    
    $peserta->catatan_pembimbing = $request->catatan_pembimbing;
    $peserta->save();
    
    return back()->with('success', 'Catatan berhasil disimpan');
}
}