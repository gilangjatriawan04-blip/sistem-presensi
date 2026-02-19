<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckDevice
{
   public function handle(Request $request, Closure $next)
{
    if (Auth::check()) {
        $user = Auth::user();
        $currentDevice = md5($request->header('User-Agent') . $request->ip() . session()->getId());

        // Jika user belum punya device_id, set sekarang
        if (!$user->device_id) {
            $user->device_id = $currentDevice;
            $user->save();
        }

        // Jika device_id tidak cocok, logout paksa
        if ($user->device_id !== $currentDevice) {
            // Beri toleransi 5 menit
            if ($user->last_login_at && $user->last_login_at->diffInMinutes(now()) < 5) {
                // Abaikan, masih dalam toleransi
            } else {
                Auth::logout();
                $request->session()->invalidate();
                return redirect()->route('login')
                    ->with('error', '❌ Akun sudah login di device lain.');
            }
        }
    }

    return $next($request);
}
}