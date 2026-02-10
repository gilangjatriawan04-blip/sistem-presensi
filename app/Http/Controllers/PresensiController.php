<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Presensi;
use App\Models\OfficeLocation;
use App\Models\Izin;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class PresensiController extends Controller
{
    /**
     * Display presensi page
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $today = Carbon::today()->format('Y-m-d');
        
        // Cek presensi hari ini
        $presensiHariIni = Presensi::where('user_id', $user->id)
            ->whereDate('tanggal', $today)
            ->first();
        
        // Cek apakah sudah ada izin untuk hari ini
        $izinHariIni = Izin::where('user_id', $user->id)
            ->where('status_approval', 'disetujui')
            ->whereDate('tanggal_mulai', '<=', $today)
            ->whereDate('tanggal_selesai', '>=', $today)
            ->first();
        
        // Get office location untuk GPS validation
        $officeLocation = OfficeLocation::where('is_aktif', true)->first();
        
        return view('presensi.index', [
            'presensi' => $presensiHariIni,
            'izin' => $izinHariIni,
            'officeLocation' => $officeLocation,
            'today' => $today,
        ]);
    }
    
    /**
     * Handle check-in (POIN 6, 7, 9)
     */
    public function checkin(Request $request)
    {
        $user = $request->user();
        $today = Carbon::today()->format('Y-m-d');
        
        // Validasi: sudah check-in hari ini?
        $existingPresensi = Presensi::where('user_id', $user->id)
            ->whereDate('tanggal', $today)
            ->first();
            
        if ($existingPresensi && $existingPresensi->jam_masuk) {
            return redirect()->back()->with('error', 'Anda sudah melakukan check-in hari ini.');
        }
        
        // Validasi: dalam periode magang? (POIN 12)
        if ($user->start_date && $user->end_date) {
            if ($today < $user->start_date || $today > $user->end_date) {
                return redirect()->back()->with('error', 'Anda berada di luar periode magang.');
            }
        }
        
        // Validasi: apakah ada izin yang disetujui? (POIN 8)
        $izin = Izin::where('user_id', $user->id)
            ->where('status_approval', 'disetujui')
            ->whereDate('tanggal_mulai', '<=', $today)
            ->whereDate('tanggal_selesai', '>=', $today)
            ->first();
            
        if ($izin) {
            // Jika izin, tidak perlu presensi
            return redirect()->back()->with('info', 'Anda sedang dalam periode izin/sakit.');
        }
        
        // Validasi input
        $request->validate([
            'latitude' => ['required', 'numeric', 'between:-90,90'],
            'longitude' => ['required', 'numeric', 'between:-180,180'],
            'keterangan' => ['nullable', 'string', 'max:500'],
        ]);
        
        // Validasi GPS (POIN 7)
        $officeLocation = OfficeLocation::where('is_aktif', true)->first();
        
        if (!$officeLocation) {
            return redirect()->back()->with('error', 'Lokasi kantor belum dikonfigurasi.');
        }
        
        // Hitung jarak menggunakan Haversine formula
        $distance = $this->calculateDistance(
            $request->latitude,
            $request->longitude,
            $officeLocation->latitude,
            $officeLocation->longitude
        );
        
        // Cek apakah dalam radius yang diizinkan
        if ($distance > $officeLocation->radius_meter) {
            return redirect()->back()->with('error', 
                'Anda berada di luar radius kantor. Jarak: ' . round($distance, 2) . 'm (Maks: ' . $officeLocation->radius_meter . 'm)');
        }
        
        // Buat atau update presensi
        if (!$existingPresensi) {
            $presensi = new Presensi();
            $presensi->user_id = $user->id;
            $presensi->tanggal = $today;
            $presensi->jam_masuk_normal = $officeLocation->jam_masuk_default;
            $presensi->jam_pulang_normal = $officeLocation->jam_pulang_default;
        } else {
            $presensi = $existingPresensi;
        }
        
        // Gunakan waktu server (POIN 6)
        $presensi->jam_masuk = Carbon::now();
        $presensi->lokasi_masuk = $request->latitude . ',' . $request->longitude;
        $presensi->keterangan = $request->keterangan;
        
        // Hitung status
        $presensi->hitungStatus();
        
        $presensi->save();
        
        return redirect()->route('presensi.index')->with('success', 'Check-in berhasil!');
    }
    
    /**
     * Handle check-out
     */
    public function checkout(Request $request)
    {
        $user = $request->user();
        $today = Carbon::today()->format('Y-m-d');
        
        // Cari presensi hari ini
        $presensi = Presensi::where('user_id', $user->id)
            ->whereDate('tanggal', $today)
            ->first();
            
        if (!$presensi) {
            return redirect()->back()->with('error', 'Anda belum melakukan check-in hari ini.');
        }
        
        if ($presensi->jam_pulang) {
            return redirect()->back()->with('error', 'Anda sudah melakukan check-out hari ini.');
        }
        
        // Validasi input
        $request->validate([
            'latitude' => ['required', 'numeric', 'between:-90,90'],
            'longitude' => ['required', 'numeric', 'between:-180,180'],
        ]);
        
        // Validasi GPS
        $officeLocation = OfficeLocation::where('is_aktif', true)->first();
        
        if (!$officeLocation) {
            return redirect()->back()->with('error', 'Lokasi kantor belum dikonfigurasi.');
        }
        
        // Hitung jarak
        $distance = $this->calculateDistance(
            $request->latitude,
            $request->longitude,
            $officeLocation->latitude,
            $officeLocation->longitude
        );
        
        // Cek apakah dalam radius
        if ($distance > $officeLocation->radius_meter) {
            return redirect()->back()->with('error', 
                'Anda berada di luar radius kantor untuk check-out.');
        }
        
        // Update presensi
        $presensi->jam_pulang = Carbon::now(); // Waktu server
        $presensi->lokasi_pulang = $request->latitude . ',' . $request->longitude;
        
        // Hitung ulang status (untuk pulang cepat)
        $presensi->hitungStatus();
        
        $presensi->save();
        
        return redirect()->route('presensi.index')->with('success', 'Check-out berhasil!');
    }
    
    /**
     * Display presensi history
     */
    public function riwayat(Request $request)
    {
        $user = $request->user();
        
        $presensis = Presensi::where('user_id', $user->id)
            ->orderBy('tanggal', 'desc')
            ->paginate(20);
        
        return view('presensi.riwayat', [
            'presensis' => $presensis,
        ]);
    }
    
    /**
     * Calculate distance between two coordinates (Haversine formula)
     */
    private function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371000; // meters
        
        $latFrom = deg2rad($lat1);
        $lonFrom = deg2rad($lon1);
        $latTo = deg2rad($lat2);
        $lonTo = deg2rad($lon2);
        
        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;
        
        $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
            cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));
        
        return $angle * $earthRadius;
    }
}