<?php

namespace App\Http\Controllers\Pasien;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class ProfilController extends Controller
{
    /**
     * Menampilkan profil pasien.
     */
    public function index(): View
    {
        $user = Auth::user();

        $pasien = $user->pasien;

        return view(
            'pasien.profil.index',
            compact('user', 'pasien')
        );
    }


    /**
     * Menampilkan form edit profil.
     */
    public function edit(): View
    {
        $user = Auth::user();

        $pasien = $user->pasien;

        return view(
            'pasien.profil.edit',
            compact('user', 'pasien')
        );
    }


    /**
     * Menyimpan perubahan profil.
     */
    public function update(
        Request $request
    ): RedirectResponse {

        $user = Auth::user();

        $pasien = $user->pasien;


        $validated = $request->validate([

            'nama_pasien' => [
                'required',
                'string',
                'max:100',
            ],

            'tanggal_lahir' => [
                'nullable',
                'date',
            ],

            'jenis_kelamin' => [
                'nullable',
                'in:Laki-laki,Perempuan',
            ],

            'alamat' => [
                'nullable',
                'string',
                'max:255',
            ],

            'no_hp' => [
                'nullable',
                'string',
                'max:20',
            ],

            'bpjs' => [
                'nullable',
                'string',
                'max:50',
            ],

        ]);


        $pasien->update($validated);


        return redirect()
            ->route('pasien.profil.index')
            ->with(
                'success',
                'Profil berhasil diperbarui.'
            );
    }
}