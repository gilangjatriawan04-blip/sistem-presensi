<?php

namespace App\Http\Controllers;

use App\Models\Izin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;  // ← TAMBAHKAN INI

class IzinController extends Controller
{
     public function index()
    {
        $user = Auth::user();
        $izins = Izin::where('user_id', $user->id)
                    ->orderBy('created_at', 'desc')
                    ->paginate(10);
        
        return view('peserta.izin.index', compact('izins'));
    }
    
    public function create()
    {
        return view('peserta.izin.create');
    }
    
    public function store(Request $request)
    {
        // DEBUG: Lihat data yang dikirim
        Log::info('===== IZIN SUBMISSION =====');
        Log::info('Data:', $request->all());
        
        try {
            $request->validate([
                'jenis_izin' => 'required|in:izin,sakit,izin_terlambat,tugas_luar',
                'alasan' => 'required|string|max:1000',
                'tanggal_mulai' => 'required|date',
                'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
                'jam_izin_terlambat' => 'nullable|date_format:H:i',
                'file_bukti' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            ]);
            
            Log::info('Validasi berhasil');
            
            // Cek izin overlapping
            $existingIzin = Izin::where('user_id', Auth::id())
                ->where('status_approval', '!=', 'ditolak')
                ->where(function($query) use ($request) {
                    $query->whereBetween('tanggal_mulai', [$request->tanggal_mulai, $request->tanggal_selesai])
                          ->orWhereBetween('tanggal_selesai', [$request->tanggal_mulai, $request->tanggal_selesai])
                          ->orWhere(function($q) use ($request) {
                              $q->where('tanggal_mulai', '<=', $request->tanggal_mulai)
                                ->where('tanggal_selesai', '>=', $request->tanggal_selesai);
                          });
                })->exists();
                
            if ($existingIzin) {
                Log::info('Izin overlapping ditemukan');
                return back()->with('error', 'Anda sudah memiliki izin dalam rentang tanggal tersebut.');
            }
            
            Log::info('Tidak ada overlapping');
            
            $izin = new Izin();
            $izin->user_id = Auth::id();
            $izin->jenis_izin = $request->jenis_izin;
            $izin->alasan = $request->alasan;
            $izin->tanggal_mulai = $request->tanggal_mulai;
            $izin->tanggal_selesai = $request->tanggal_selesai;
            $izin->jam_izin_terlambat = $request->jam_izin_terlambat;
            $izin->status_approval = 'pending';
            
            Log::info('Data izin sebelum save:', $izin->toArray());
            
            // Upload file
           // Upload file
if ($request->hasFile('file_bukti')) {
    $path = $request->file('file_bukti')->store('izin_bukti', 'public');
    $izin->file_bukti = $path;
    Log::info('File uploaded: ' . $path);
}
            
            $izin->save();
            Log::info('Izin saved with ID: ' . $izin->id);
            
            return redirect()->route('izin.index')
                ->with('success', 'Izin berhasil diajukan. Menunggu persetujuan admin.');
                
        } catch (\Exception $e) {
            Log::error('ERROR: ' . $e->getMessage());
            return back()->with('error', 'Gagal mengajukan izin: ' . $e->getMessage());
        }
    }
    
    public function show(Izin $izin)
    {
        // Authorization
        if ($izin->user_id !== Auth::id()) {
            abort(403);
        }
        
        return view('peserta.izin.show', compact('izin'));
    }

    public function download(Izin $izin)
{
    // Authorization
    if ($izin->user_id !== Auth::id()) {
        abort(403);
    }
    
    if (!$izin->file_bukti) {
        abort(404, 'File tidak ditemukan.');
    }
    
    $path = storage_path('app/public/' . $izin->file_bukti);
    
    if (!file_exists($path)) {
        abort(404, 'File fisik tidak ditemukan.');
    }
    
    return response()->download($path);
}
}


   