<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PresensiController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Group untuk route yang perlu auth
Route::middleware('auth')->group(function () {
    // Profile routes (from Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Presensi routes
    Route::prefix('presensi')->group(function () {
        Route::get('/', [PresensiController::class, 'index'])->name('presensi.index');
        Route::post('/checkin', [PresensiController::class, 'checkin'])->name('presensi.checkin');
        Route::post('/checkout', [PresensiController::class, 'checkout'])->name('presensi.checkout');
        Route::get('/riwayat', [PresensiController::class, 'riwayat'])->name('presensi.riwayat');
    });
    
    // Admin only routes
    Route::middleware('role:admin')->group(function () {
        Route::get('/admin/users', function () {
            return view('admin.users.index');
        })->name('admin.users.index');
        
        Route::get('/admin/izins', function () {
            return view('admin.izins.index');
        })->name('admin.izins.index');
        
        Route::get('/admin/reports', function () {
            return view('admin.reports.index');
        })->name('admin.reports.index');
    });
    
    // Pembimbing routes
    Route::middleware('role:pembimbing')->group(function () {
        Route::get('/pembimbing/monitoring', function () {
            return view('pembimbing.monitoring');
        })->name('pembimbing.monitoring');
    });
});

require __DIR__.'/auth.php';