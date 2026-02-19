<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    public function create(): View
    {
        return view('auth.login');
    }

    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();
        $request->session()->regenerate();

        $user = Auth::user();

        $deviceId = md5(
            $request->header('User-Agent') .
            $request->ip()
        );

        if ($user->device_id && $user->device_id !== $deviceId) {
            Auth::logout();
            $request->session()->invalidate();

            return redirect()->route('login')
                ->with('error', 'Akun sudah login di device lain.');
        }

        $user->device_id = $deviceId;
        $user->last_login_at = now();
        $user->last_login_ip = $request->ip();
        $user->save();

        return redirect()->intended(route('dashboard'));
    }

    public function destroy(Request $request): RedirectResponse
    {
        if (Auth::check()) {
            $user = Auth::user();
            $user->device_id = null;
            $user->save();
        }

        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}