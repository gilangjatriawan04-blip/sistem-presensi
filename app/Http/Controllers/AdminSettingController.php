<?php

namespace App\Http\Controllers;

use App\Models\OfficeLocation;
use Illuminate\Http\Request;

class AdminSettingController extends Controller
{
    /**
     * Display settings page.
     */
    public function index()
    {
        $office = OfficeLocation::first();
        
        if (!$office) {
            $office = new OfficeLocation();
        }
        
        return view('admin.settings.index', compact('office'));
    }
    
    /**
     * Update office location settings.
     */
  public function update(Request $request)
{
    // Validasi data
    $request->validate([
        'nama_lokasi' => 'required|string|max:255',
        'alamat' => 'nullable|string',
        'latitude' => ['required', 'numeric'],
        'longitude' => ['required', 'numeric'],
        'radius_meter' => 'required|integer|min:10|max:5000',
        'jam_masuk_default' => 'required',
        'jam_pulang_default' => 'required',
    ]);

    // Cari atau buat baru
    $office = OfficeLocation::first();
    
    if (!$office) {
        $office = new OfficeLocation();
    }
    
    // Simpan data
    $office->nama_lokasi = $request->nama_lokasi;
    $office->alamat = $request->alamat;
    $office->latitude = $request->latitude;
    $office->longitude = $request->longitude;
    $office->radius_meter = $request->radius_meter;
    
    // Format jam: tambah :00 untuk detik
    $office->jam_masuk_default = $request->jam_masuk_default . ':00';
    $office->jam_pulang_default = $request->jam_pulang_default . ':00';
    
    // Status aktif
    $office->is_aktif = $request->has('is_aktif') ? true : false;
    
    // Simpan ke database
    $office->save();
    
    // Redirect dengan pesan sukses
    return redirect()->route('admin.settings.index')
        ->with('success', 'Pengaturan berhasil disimpan.');
}
}