<?php

namespace App\Http\Controllers;

use App\Models\Izin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AdminIzinController extends Controller
{
    /**
     * Display a listing of pending izins.
     */
    public function index(Request $request)
    {
        $status = $request->get('status', 'pending');
        
        $izins = Izin::with('user')
            ->when($status != 'all', function($query) use ($status) {
                return $query->where('status_approval', $status);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(15);
        
        $stats = [
            'pending' => Izin::where('status_approval', 'pending')->count(),
            'disetujui' => Izin::where('status_approval', 'disetujui')->count(),
            'ditolak' => Izin::where('status_approval', 'ditolak')->count(),
            'total' => Izin::count(),
        ];
        
        return view('admin.izins.index', compact('izins', 'stats', 'status'));
    }
    
    /**
     * Show izin detail for approval.
     */
    public function show(Izin $izin)
    {
        $izin->load('user', 'approvedBy');
        
        return view('admin.izins.show', compact('izin'));
    }
    
    /**
     * Approve an izin request.
     */
    public function approve(Request $request, Izin $izin)
    {
        $request->validate([
            'catatan_admin' => 'nullable|string|max:500',
        ]);
        
        $izin->status_approval = 'disetujui';
        $izin->approved_by = Auth::id();
        $izin->approved_at = now();
        $izin->catatan_admin = $request->catatan_admin;
        $izin->save();
        
        // TODO: Send notification to user
        
        return redirect()->route('admin.izin.index')
            ->with('success', 'Izin telah disetujui.');
    }
    
    /**
     * Reject an izin request.
     */
    public function reject(Request $request, Izin $izin)
    {
        $request->validate([
            'catatan_admin' => 'required|string|max:500',
        ]);
        
        $izin->status_approval = 'ditolak';
        $izin->approved_by = Auth::id();
        $izin->approved_at = now();
        $izin->catatan_admin = $request->catatan_admin;
        $izin->save();
        
        // TODO: Send notification to user
        
        return redirect()->route('admin.izin.index')
            ->with('success', 'Izin telah ditolak.');
    }
    
    /**
     * Download bukti file.
     */
    public function downloadBukti(Izin $izin)
{
    // Cek apakah file ada di database
    if (!$izin->file_bukti) {
        abort(404, 'File tidak ditemukan di database.');
    }
    
    // Path lengkap file
    $path = storage_path('app/public/' . $izin->file_bukti);
    
    // Cek apakah file fisik ada
    if (!file_exists($path)) {
        abort(404, 'File fisik tidak ditemukan di storage. Path: ' . $path);
    }
    
    // Download file
    return response()->download($path);
}
}