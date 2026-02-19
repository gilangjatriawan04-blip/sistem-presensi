<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PresensiController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\IzinController;
use App\Http\Controllers\AdminIzinController;
use App\Http\Controllers\AdminSettingController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\PembimbingController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| AUTHENTICATED ROUTES (with device middleware)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', \App\Http\Middleware\CheckDevice::class])->group(function () {
    
    // Dashboard (HANYA SATU)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/profile/avatar', [ProfileController::class, 'updateAvatar'])->name('profile.avatar');
});

/*
|--------------------------------------------------------------------------
| PESERTA ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', \App\Http\Middleware\CheckDevice::class, 'role:peserta'])->group(function () {
    
    // PRESENSI
    Route::prefix('presensi')->name('presensi.')->group(function () {
        Route::get('/', [PresensiController::class, 'index'])->name('index');
        Route::post('/checkin', [PresensiController::class, 'checkin'])->name('checkin');
        Route::post('/checkout', [PresensiController::class, 'checkout'])->name('checkout');
        Route::get('/riwayat', [PresensiController::class, 'riwayat'])->name('riwayat');
    });

    // IZIN
    Route::prefix('izin')->name('izin.')->group(function () {
        Route::get('/', [IzinController::class, 'index'])->name('index');
        Route::get('/create', [IzinController::class, 'create'])->name('create');
        Route::post('/', [IzinController::class, 'store'])->name('store');
        Route::get('/{izin}', [IzinController::class, 'show'])->name('show');
    });
});

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', \App\Http\Middleware\CheckDevice::class, 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

    // Dashboard
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    // USERS
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [AdminUserController::class, 'index'])->name('index');
        
        Route::get('/create/admin', [AdminUserController::class, 'createAdmin'])->name('create.admin');
        Route::post('/store-admin', [AdminUserController::class, 'storeAdmin'])->name('store.admin');
        
        Route::get('/create/pembimbing', [AdminUserController::class, 'createPembimbing'])->name('create.pembimbing');
        Route::post('/store-pembimbing', [AdminUserController::class, 'storePembimbing'])->name('store.pembimbing');
        
        Route::get('/create/peserta', [AdminUserController::class, 'createPeserta'])->name('create.peserta');
        Route::post('/store-peserta', [AdminUserController::class, 'storePeserta'])->name('store.peserta');
        
        Route::get('/{user}/edit', [AdminUserController::class, 'edit'])->name('edit');
        Route::put('/{user}', [AdminUserController::class, 'update'])->name('update');
        Route::delete('/{user}', [AdminUserController::class, 'destroy'])->name('destroy');
        
        Route::post('/{user}/reset-password', [AdminUserController::class, 'resetPassword'])->name('reset-password');
    });

    // IZIN
    Route::prefix('izin')->name('izin.')->group(function () {
        Route::get('/', [AdminIzinController::class, 'index'])->name('index');
        Route::get('/{izin}', [AdminIzinController::class, 'show'])->name('show');
        Route::patch('/{izin}/approve', [AdminIzinController::class, 'approve'])->name('approve');
        Route::patch('/{izin}/reject', [AdminIzinController::class, 'reject'])->name('reject');
        Route::get('/{izin}/download', [AdminIzinController::class, 'downloadBukti'])->name('download');
    });

    // SETTINGS
    Route::prefix('settings')->name('settings.')->group(function () {
        Route::get('/', [AdminSettingController::class, 'index'])->name('index');
        Route::post('/', [AdminSettingController::class, 'update'])->name('update');
    });

    // REPORTS
    Route::get('/reports', function () { 
        return view('admin.reports.index');
    })->name('reports.index');
});

/*
|--------------------------------------------------------------------------
| PEMBIMBING ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', \App\Http\Middleware\CheckDevice::class, 'role:pembimbing'])
    ->prefix('pembimbing')
    ->name('pembimbing.')
    ->group(function () {
        Route::get('/dashboard', [PembimbingController::class, 'dashboard'])->name('dashboard');
        Route::get('/peserta', [PembimbingController::class, 'peserta'])->name('peserta');
        Route::get('/peserta/{id}', [PembimbingController::class, 'detailPeserta'])->name('peserta.detail');
        Route::get('/izin', [PembimbingController::class, 'izin'])->name('izin');
        Route::patch('/peserta/{id}/catatan', [PembimbingController::class, 'updateCatatan'])->name('catatan.update');
});

require __DIR__.'/auth.php';