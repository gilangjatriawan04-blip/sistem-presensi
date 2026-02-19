<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRoleOnly
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        $user = $request->user();
        
        if (!$user) {
            return redirect()->route('login');
        }
        
        // Admin bisa akses semua
        if ($user->role === 'admin') {
            return $next($request);
        }
        
        // Cek role yang diminta
        if ($user->role !== $role) {
            abort(403, 'Unauthorized access.');
        }
        
        return $next($request);
    }
}