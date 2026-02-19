<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();

        // Validasi dasar
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'jenis_peserta' => 'nullable|in:mahasiswa,smk,pegawai,lainnya',
            'institution_name' => 'nullable|string|max:255',
            'institution_class' => 'nullable|string|max:100',
            'nim_nisn' => 'nullable|string|max:50',
        ];

        // Hanya validasi start_date & end_date jika belum diisi sebelumnya
        if (empty($user->start_date) || empty($user->end_date)) {
            $rules['start_date'] = 'nullable|date';
            $rules['end_date'] = 'nullable|date|after_or_equal:start_date';
        }

        $request->validate($rules);

        // Update data yang boleh diubah
        $user->name = $request->name;
        $user->email = $request->email;
        $user->jenis_peserta = $request->jenis_peserta;
        $user->institution_name = $request->institution_name;
        $user->institution_class = $request->institution_class;
        $user->nim_nisn = $request->nim_nisn;

        // Hanya update start_date & end_date jika belum pernah diisi
        if (empty($user->start_date) && $request->filled('start_date')) {
            $user->start_date = $request->start_date;
        }
        
        if (empty($user->end_date) && $request->filled('end_date')) {
            $user->end_date = $request->end_date;
        }

        $user->save();

        return back()->with('status', 'profile-updated');
    }

    /**
     * Update avatar via AJAX
     */
    public function updateAvatar(Request $request)
    {
        try {
            $request->validate([
                'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $user = $request->user();
            
            // Hapus avatar lama jika ada
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }

            // Upload avatar baru
            $path = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $path;
            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'Foto profile berhasil diperbarui!',
                'avatar' => asset('storage/' . $path)
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal upload: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        // Hapus avatar jika ada
        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
        }

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}