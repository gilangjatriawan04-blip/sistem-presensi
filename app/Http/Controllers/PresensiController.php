<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Presensi;
use App\Models\OfficeLocation;
use App\Models\Izin;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PresensiController extends Controller
{
    /**
     * Display presensi page dengan informasi jam kerja
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $today = Carbon::today()->format('Y-m-d');
        $now = Carbon::now();
        
        // Cek presensi hari ini
        $presensiHariIni = Presensi::where('user_id', $user->id)
            ->whereDate('tanggal', $today)
            ->first();
        
        // Cek izin yang disetujui untuk hari ini
        $izinHariIni = Izin::where('user_id', $user->id)
            ->where('status_approval', 'disetujui')
            ->whereDate('tanggal_mulai', '<=', $today)
            ->whereDate('tanggal_selesai', '>=', $today)
            ->first();
        
        // Cek izin terlambat yang disetujui untuk hari ini
        $izinTerlambat = Izin::where('user_id', $user->id)
            ->where('jenis_izin', 'izin_terlambat')
            ->where('status_approval', 'disetujui')
            ->whereDate('tanggal_mulai', '<=', $today)
            ->whereDate('tanggal_selesai', '>=', $today)
            ->first();
        
        // Get office location untuk GPS validation
        $officeLocation = OfficeLocation::where('is_aktif', true)->first();
        
        // Informasi jam kerja untuk ditampilkan di view
        $jamInfo = [];
        if ($officeLocation) {
            $jamMasuk = Carbon::parse($officeLocation->jam_masuk_default);
            $jamPulang = Carbon::parse($officeLocation->jam_pulang_default);
            
            $jamInfo = [
                'jam_masuk' => $jamMasuk->format('H:i'),
                'jam_pulang' => $jamPulang->format('H:i'),
                'batas_terlambat' => $jamMasuk->copy()->addMinutes(60)->format('H:i'),
                'boleh_checkin' => $now >= $jamMasuk && $now <= $jamMasuk->copy()->addMinutes(60),
                'boleh_checkout' => $presensiHariIni ? ($now >= $jamPulang) : false,
                'izin_terlambat' => $izinTerlambat ? true : false,
            ];
        }
        
        return view('peserta.presensi.index', [
            'presensi' => $presensiHariIni,
            'izin' => $izinHariIni,
            'izinTerlambat' => $izinTerlambat,
            'officeLocation' => $officeLocation,
            'today' => $today,
            'jamInfo' => $jamInfo,
            'now' => $now->format('H:i'),
        ]);
    }
    
    /**
     * Handle check-in dengan validasi jam masuk dan izin terlambat
     */
    public function checkin(Request $request)
    {
        $user = $request->user();
        $today = Carbon::today()->format('Y-m-d');
        $now = Carbon::now();
        
        // Validasi: sudah check-in hari ini?
        $existingPresensi = Presensi::where('user_id', $user->id)
            ->whereDate('tanggal', $today)
            ->first();
            
        if ($existingPresensi && $existingPresensi->jam_masuk) {
            return redirect()->back()->with('error', '❌ Anda sudah melakukan check-in hari ini.');
        }
        
        // Validasi: dalam periode magang?
        if ($user->start_date && $user->end_date) {
            $start = Carbon::parse($user->start_date);
            $end = Carbon::parse($user->end_date);
            $todayDate = Carbon::today();

            if ($todayDate->lt($start) || $todayDate->gt($end)) {
                return redirect()->back()->with('error', '❌ Anda berada di luar periode magang.');
            }
        }
        
        // Validasi: apakah ada izin sakit/izin biasa yang disetujui?
        $izin = Izin::where('user_id', $user->id)
            ->where('status_approval', 'disetujui')
            ->whereIn('jenis_izin', ['izin', 'sakit', 'tugas_luar'])
            ->whereDate('tanggal_mulai', '<=', $today)
            ->whereDate('tanggal_selesai', '>=', $today)
            ->first();
            
        if ($izin) {
            return redirect()->back()->with('info', '📋 Anda sedang dalam periode izin/sakit.');
        }
        
        // Ambil lokasi kantor
        $officeLocation = OfficeLocation::where('is_aktif', true)->first();
        
        if (!$officeLocation) {
            return redirect()->back()->with('error', '📍 Lokasi kantor belum dikonfigurasi.');
        }
        
        // ===== VALIDASI JAM MASUK DENGAN IZIN TERLAMBAT =====
        $jamMasukNormal = Carbon::parse($officeLocation->jam_masuk_default);
        $batasTerlambat = $jamMasukNormal->copy()->addMinutes(60);
        
        // Cek apakah ada izin terlambat yang disetujui untuk hari ini
        $izinTerlambat = Izin::where('user_id', $user->id)
            ->where('jenis_izin', 'izin_terlambat')
            ->where('status_approval', 'disetujui')
            ->whereDate('tanggal_mulai', '<=', $today)
            ->whereDate('tanggal_selesai', '>=', $today)
            ->first();
        
        // Validasi: belum waktunya check-in
      if ($now < $jamMasukNormal) {
    $selisih = (int) abs($jamMasukNormal->diffInMinutes($now));
    return redirect()->back()->with('warning', 
        "⏰ Belum waktunya check-in. Masih $selisih menit lagi menuju jam masuk (jam " . 
        $jamMasukNormal->format('H:i') . ").");
}
        
        $menitTerlambat = $jamMasukNormal->diffInMinutes($now);
        
        // Jika sudah melewati jam masuk normal (terlambat)
        if ($menitTerlambat > 0) {
            
            // Jika TIDAK ada izin terlambat
            if (!$izinTerlambat) {
                
                // Terlambat > 60 menit
           // Validasi jam masuk
$menitTerlambat = (int) $jamMasukNormal->diffInMinutes($now);

if ($menitTerlambat > 0) {
    if (!$izinTerlambat) {
       if ($menitTerlambat > 60) {
    return redirect()->back()
        ->with('error', "⏰ Anda terlambat " . (int)$menitTerlambat . " menit (lebih dari 60 menit) dan tidak memiliki izin terlambat.")
        ->with('show_izin_button', true);
}
        if ($menitTerlambat <= 60) {
            session()->flash('warning', 
                "⚠️ Anda terlambat {$menitTerlambat} menit. Anda tetap bisa check-in dengan status 'terlambat'.");
        }
    } else {
        session()->flash('info', "✅ Anda menggunakan izin terlambat. Terlambat {$menitTerlambat} menit.");
    }
}
                
                // Terlambat 1-60 menit (masih toleransi)
               if ($menitTerlambat > 60) {
    return redirect()->back()
        ->with('warning', "⏰ Anda terlambat " . (int)$menitTerlambat . " menit (lebih dari 60 menit) dan tidak memiliki izin terlambat.")
        ->with('show_izin_button', true);
}
            }
            
            // Jika ADA izin terlambat
            if ($izinTerlambat) {
                session()->flash('info', "✅ Anda menggunakan izin terlambat. Terlambat {$menitTerlambat} menit.");
            }
        }
        // ===== END VALIDASI JAM MASUK =====
        
        // Validasi input GPS
        $request->validate([
            'latitude' => ['required', 'numeric', 'between:-90,90'],
            'longitude' => ['required', 'numeric', 'between:-180,180'],
            'keterangan' => ['nullable', 'string', 'max:500'],
        ]);
        
        // Hitung jarak dengan kantor
        $distance = $this->calculateDistance(
            $request->latitude,
            $request->longitude,
            $officeLocation->latitude,
            $officeLocation->longitude
        );
        
        // Validasi radius
        if ($distance > $officeLocation->radius_meter) {
            return redirect()->back()->with('error', 
                '📍 Anda berada di luar radius kantor. Jarak: ' . round($distance, 2) . 'm (Maks: ' . $officeLocation->radius_meter . 'm)');
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
        
        // Simpan data check-in
        $presensi->jam_masuk = $now;
        $presensi->lokasi_masuk = $request->latitude . ',' . $request->longitude;
        $presensi->keterangan = $request->keterangan;
        
        // Hitung status
        $presensi->hitungStatus();
        
        $presensi->save();
        
        return redirect()->route('presensi.index')->with('success', '✅ Check-in berhasil!');
    }

    /**
     * Handle check-out dengan validasi jam pulang
     */
    public function checkout(Request $request)
    {
        $user = $request->user();
        $today = Carbon::today()->format('Y-m-d');
        $now = Carbon::now();
        
        // Cari presensi hari ini
        $presensi = Presensi::where('user_id', $user->id)
            ->whereDate('tanggal', $today)
            ->first();
            
        if (!$presensi) {
            return redirect()->back()->with('error', '❌ Anda belum melakukan check-in hari ini.');
        }
        
        if ($presensi->jam_pulang) {
            return redirect()->back()->with('error', '✅ Anda sudah melakukan check-out hari ini.');
        }
        
        // Ambil lokasi kantor
        $officeLocation = OfficeLocation::where('is_aktif', true)->first();
        
        // ===== VALIDASI JAM PULANG =====
        $jamPulangNormal = Carbon::parse($presensi->jam_pulang_normal);
        
        if ($now < $jamPulangNormal) {
            $selisih = $jamPulangNormal->diffInMinutes($now);
            $jam = floor($selisih / 60);
            $menit = $selisih % 60;
            
            if ($jam > 0) {
                $pesan = "⏰ Anda belum bisa check-out. Masih $jam jam $menit menit lagi menuju jam pulang (jam " . 
                         $jamPulangNormal->format('H:i') . ").";
            } else {
                $pesan = "⏰ Anda belum bisa check-out. Masih $menit menit lagi menuju jam pulang (jam " . 
                         $jamPulangNormal->format('H:i') . ").";
            }
            
            return redirect()->back()->with('warning', $pesan);
        }
        // ===== END VALIDASI JAM PULANG =====
        
        // Validasi input GPS
        $request->validate([
            'latitude' => ['required', 'numeric', 'between:-90,90'],
            'longitude' => ['required', 'numeric', 'between:-180,180'],
        ]);
        
        if (!$officeLocation) {
            return redirect()->back()->with('error', '📍 Lokasi kantor belum dikonfigurasi.');
        }
        
        // Hitung jarak dengan kantor
        $distance = $this->calculateDistance(
            $request->latitude,
            $request->longitude,
            $officeLocation->latitude,
            $officeLocation->longitude
        );
        
        // Validasi radius
        if ($distance > $officeLocation->radius_meter) {
            return redirect()->back()->with('error', 
                '📍 Anda berada di luar radius kantor. Jarak: ' . round($distance, 2) . 'm (Maks: ' . $officeLocation->radius_meter . 'm)');
        }
        
        // Update data check-out
        $presensi->jam_pulang = $now;
        $presensi->lokasi_pulang = $request->latitude . ',' . $request->longitude;
        
        // Hitung ulang status
        $presensi->hitungStatus();
        
        $presensi->save();
        
        // Hitung total jam kerja
        $totalJam = floor($presensi->total_kerja_menit / 60);
        $totalMenit = $presensi->total_kerja_menit % 60;
        
        return redirect()->route('presensi.index')->with('success', 
            "✅ Check-out berhasil! Total kerja: {$totalJam} jam {$totalMenit} menit.");
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
        
        return view('peserta.presensi.riwayat', [
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