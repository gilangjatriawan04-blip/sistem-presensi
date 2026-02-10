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
   public function update(Request $request)
{
    $user = $request->user();
    
    // Simpan data
    $user->name = $request->name;
    $user->email = $request->email;
    $user->jenis_peserta = $request->jenis_peserta;
    $user->institution_name = $request->institution_name;
    $user->institution_class = $request->institution_class;
    $user->nim_nisn = $request->nim_nisn;
    $user->supervisor_name = $request->supervisor_name;
    $user->supervisor_contact = $request->supervisor_contact;
    $user->start_date = $request->start_date;
    $user->end_date = $request->end_date;
    
    $user->save();
    
    return redirect()->route('profile.edit')->with('status', 'profile-updated');
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