<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AdminUserController extends Controller
{
    /**
     * ============================================
     * MENAMPILKAN DAFTAR SEMUA USER
     * ============================================
     * URL: /admin/users
     * Method: GET
     * View: admin/users/index.blade.php
     */
    public function index(Request $request)
    {
        // Ambil parameter filter
        $role = $request->get('role', '');
        $search = $request->get('search', '');
        
        // Query users
        $users = User::query();
        
        // Filter berdasarkan role
        if ($role) {
            $users->where('role', $role);
        }
        
        // Pencarian berdasarkan nama atau email
        if ($search) {
            $users->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }
        
        // Urutkan dan paginasi
        $users = $users->orderBy('created_at', 'desc')
                       ->paginate(15)
                       ->withQueryString();
        
        // Statistik
        $stats = [
            'total' => User::count(),
            'admin' => User::where('role', 'admin')->count(),
            'pembimbing' => User::where('role', 'pembimbing')->count(),
            'peserta' => User::where('role', 'peserta')->count(),
            'magang_aktif' => User::where('role', 'peserta')
                ->whereDate('start_date', '<=', now())
                ->whereDate('end_date', '>=', now())
                ->count(),
        ];
        
        
        return view('admin.users.index', compact('users', 'stats', 'role', 'search'));
    }

    /**
     * ============================================
     * MENAMPILKAN FORM TAMBAH USER
     * ============================================
     * URL: /admin/users/create
     * Method: GET
     * View: admin/users/create.blade.php
     */
    public function create()
    {
        // Data untuk dropdown
        $jenisPesertaOptions = [
            'mahasiswa' => 'Mahasiswa',
            'smk' => 'SMK/SMA',
            'pegawai' => 'Pegawai',
            'lainnya' => 'Lainnya'
        ];
        
        $roleOptions = [
            'admin' => 'Admin',
            'pembimbing' => 'Pembimbing',
            'peserta' => 'Peserta Magang'
        ];
        
        return view('admin.users.create', compact('jenisPesertaOptions', 'roleOptions'));
    }

    /**
     * ============================================
     * MENYIMPAN USER BARU KE DATABASE
     * ============================================
     * URL: /admin/users
     * Method: POST
     * Redirect: ke halaman index
     */
    public function store(Request $request)
    {
        // Validasi data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'role' => 'required|in:admin,pembimbing,peserta',
            'jenis_peserta' => 'nullable|in:mahasiswa,smk,pegawai,lainnya',
            'institution_name' => 'nullable|string|max:255',
            'institution_class' => 'nullable|string|max:100',
            'nim_nisn' => 'nullable|string|max:50',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);
        
        // Buat user baru
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->role = $request->role;
        $user->jenis_peserta = $request->jenis_peserta;
        $user->institution_name = $request->institution_name;
        $user->institution_class = $request->institution_class;
        $user->nim_nisn = $request->nim_nisn;
        $user->start_date = $request->start_date;
        $user->end_date = $request->end_date;
        $user->save();
        
        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil ditambahkan!');
    }

    /**
     * ============================================
     * MENAMPILKAN FORM EDIT USER
     * ============================================
     * URL: /admin/users/{user}/edit
     * Method: GET
     * View: admin/users/edit.blade.php
     */
    public function edit(User $user)
    {
        // Data untuk dropdown
        $jenisPesertaOptions = [
            'mahasiswa' => 'Mahasiswa',
            'smk' => 'SMK/SMA',
            'pegawai' => 'Pegawai',
            'lainnya' => 'Lainnya'
        ];
        
        $roleOptions = [
            'admin' => 'Admin',
            'pembimbing' => 'Pembimbing',
            'peserta' => 'Peserta Magang'
        ];
        
        return view('admin.users.edit', compact('user', 'jenisPesertaOptions', 'roleOptions'));
    }

    /**
     * ============================================
     * MENGUPDATE DATA USER
     * ============================================
     * URL: /admin/users/{user}
     * Method: PUT
     * Redirect: ke halaman index
     */
    public function update(Request $request, User $user)
    {
        // Validasi data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:admin,pembimbing,peserta',
            'jenis_peserta' => 'nullable|in:mahasiswa,smk,pegawai,lainnya',
            'institution_name' => 'nullable|string|max:255',
            'institution_class' => 'nullable|string|max:100',
            'nim_nisn' => 'nullable|string|max:50',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);
        
        // Update data
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;
        $user->jenis_peserta = $request->jenis_peserta;
        $user->institution_name = $request->institution_name;
        $user->institution_class = $request->institution_class;
        $user->nim_nisn = $request->nim_nisn;
        $user->start_date = $request->start_date;
        $user->end_date = $request->end_date;
        $user->save();
        
        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil diupdate!');
    }

    /**
     * ============================================
     * RESET PASSWORD USER
     * ============================================
     * URL: /admin/users/{user}/reset-password
     * Method: POST
     * Redirect: ke halaman index
     */
    public function resetPassword(Request $request, User $user)
    {
        $request->validate([
            'password' => 'required|min:8|confirmed',
        ]);
        
        $user->password = Hash::make($request->password);
        $user->save();
        
        return redirect()->route('admin.users.index')
            ->with('success', "Password user {$user->name} berhasil direset!");
    }

    /**
     * ============================================
     * MENGHAPUS USER
     * ============================================
     * URL: /admin/users/{user}
     * Method: DELETE
     * Redirect: ke halaman index
     */
    public function destroy(User $user)
    {
        // Cegah hapus diri sendiri
        if ($user->id === Auth::id()) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Anda tidak dapat menghapus akun sendiri!');
        }
        
        $userName = $user->name;
        $user->delete();
        
        return redirect()->route('admin.users.index')
            ->with('success', "User {$userName} berhasil dihapus!");
    }

    /**
 * ============================================
 * FORM TAMBAH ADMIN
 * ============================================
 * Hanya untuk staff/HRD kantor
 * Field: Nama, Email, Password
 * Role otomatis: admin
 */
public function createAdmin()
{
    return view('admin.users.create-admin', [
        'title' => 'Tambah Admin Baru',
        'role' => 'admin',
        'roleLabel' => 'Admin',
        'description' => 'Akun untuk staff/HRD yang mengelola sistem'
    ]);
}

/**
 * ============================================
 * PROSES SIMPAN ADMIN
 * ============================================
 */
public function storeAdmin(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:8|confirmed',
    ]);

    $user = new User();
    $user->name = $request->name;
    $user->email = $request->email;
    $user->password = Hash::make($request->password);
    $user->role = 'admin'; // OTOMATIS ADMIN
    $user->save();

    return redirect()->route('admin.users.index')
        ->with('success', "✅ Admin {$user->name} berhasil ditambahkan!");
}

/**
 * ============================================
 * FORM TAMBAH PEMBIMBING
 * ============================================
 * Untuk dosen/guru pembimbing
 * Field: Nama, Email, Password, Nama Institusi
 * Role otomatis: pembimbing
 */
public function createPembimbing()
{
    return view('admin.users.create-pembimbing', [
        'title' => 'Tambah Pembimbing Baru',
        'role' => 'pembimbing',
        'roleLabel' => 'Pembimbing',
        'description' => 'Akun untuk dosen/guru pembimbing dari institusi'
    ]);
}

/**
 * ============================================
 * PROSES SIMPAN PEMBIMBING
 * ============================================
 */
public function storePembimbing(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:8|confirmed',
        'institution_name' => 'required|string|max:255',
    ]);

    $user = new User();
    $user->name = $request->name;
    $user->email = $request->email;
    $user->password = Hash::make($request->password);
    $user->role = 'pembimbing'; // OTOMATIS PEMBIMBING
    $user->institution_name = $request->institution_name;
    $user->save();

    return redirect()->route('admin.users.index')
        ->with('success', "✅ Pembimbing {$user->name} dari {$user->institution_name} berhasil ditambahkan!");
}



/**
 * ============================================
 * FORM TAMBAH PESERTA MAGANG
 * ============================================
 * Untuk mahasiswa/siswa magang (data lengkap)
 * Field: Nama, Email, Password, Jenis Peserta, Institusi, NIM/NISN, Kelas, Tanggal Magang
 * Role otomatis: peserta
 */
public function createPeserta()
{
    $jenisPesertaOptions = [
        'mahasiswa' => 'Mahasiswa (D3/S1)',
        'smk' => 'SMK/SMA Sederajat',
        'pegawai' => 'Pegawai',
        'lainnya' => 'Lainnya'
    ];

    return view('admin.users.create-peserta', [
        'title' => 'Tambah Peserta Magang Baru',
        'role' => 'peserta',
        'roleLabel' => 'Peserta Magang',
        'description' => 'Akun untuk mahasiswa/siswa yang akan magang',
        'jenisPesertaOptions' => $jenisPesertaOptions
    ]);
}

/**
 * ============================================
 * PROSES SIMPAN PESERTA
 * ============================================
 */
public function storePeserta(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:8|confirmed',
    ]);

    $user = new User();
    $user->name = $request->name;
    $user->email = $request->email;
    $user->password = Hash::make($request->password);
    $user->role = 'peserta'; // OTOMATIS PESERTA
    $user->save();

     $stats = [
        'total' => User::count(),
        'admin' => User::where('role', 'admin')->count(),
        'pembimbing' => User::where('role', 'pembimbing')->count(),
        'peserta' => User::where('role', 'peserta')->count(),
        'magang_aktif' => User::where('role', 'peserta')
            ->whereDate('start_date', '<=', now())
            ->whereDate('end_date', '>=', now())
            ->count(),
    ];
    

    return redirect()->route('admin.users.index')
        ->with('success', "✅ Peserta {$user->name} berhasil ditambahkan!");
}

}