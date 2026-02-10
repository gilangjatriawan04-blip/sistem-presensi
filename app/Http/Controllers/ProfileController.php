<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $user = $request->user();
        
        // Data untuk dropdown
        $jenisPesertaOptions = [
            'mahasiswa' => 'Mahasiswa',
            'smk' => 'SMK/SMA', 
            'pegawai' => 'Pegawai',
            'lainnya' => 'Lainnya'
        ];
        
        return view('profile.edit', [
            'user' => $user,
            'jenisPesertaOptions' => $jenisPesertaOptions,
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        
        // Validasi tambahan untuk data magang
        $request->validate([
            'jenis_peserta' => ['required', 'in:mahasiswa,smk,pegawai,lainnya'],
            'institution_name' => ['nullable', 'string', 'max:255'],
            'institution_class' => ['nullable', 'string', 'max:100'],
            'nim_nisn' => ['nullable', 'string', 'max:50'],
            'supervisor_name' => ['nullable', 'string', 'max:255'],
            'supervisor_contact' => ['nullable', 'string', 'max:20'],
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
        ]);

        // Update data user
        $user->fill($request->only([
            'name', 'email', 'jenis_peserta', 'institution_name', 
            'institution_class', 'nim_nisn', 'supervisor_name', 
            'supervisor_contact', 'start_date', 'end_date'
        ]));

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
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

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}