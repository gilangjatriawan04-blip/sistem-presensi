<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckProfileComplete
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        
        // Admin tidak perlu melengkapi profile magang
        if ($user && $user->role === 'admin') {
            return $next($request);
        }
        
        // Cek apakah data magang sudah lengkap
        if ($user && !$this->isProfileComplete($user)) {
            // Redirect ke profile edit jika belum lengkap
            // Kecuali sedang di halaman profile atau logout
            if (!$request->is('profile*') && !$request->is('logout')) {
                return redirect()->route('profile.edit')
                    ->with('warning', 'Silakan lengkapi data magang Anda terlebih dahulu.');
            }
        }
        
        return $next($request);
    }
    
    private function isProfileComplete($user)
    {
        // Cek field wajib untuk peserta magang
        $requiredFields = ['jenis_peserta', 'institution_name', 'start_date', 'end_date'];
        
        foreach ($requiredFields as $field) {
            if (empty($user->$field)) {
                return false;
            }
        }
        
        return true;
    }
}