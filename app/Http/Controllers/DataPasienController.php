<?php

namespace App\Http\Controllers;

use App\Http\Requests\PasienRequest;
use App\Models\Pasien;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\View\View;

class DataPasienController extends Controller
{
    /**
     * Menampilkan form pendaftaran pasien.
     */
    public function create(): View
    {
        return view('pasien.create');
    }

    /**
     * Menyimpan data pasien.
     */
    public function store(PasienRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $data['id_pasien'] = 'PSN-' . strtoupper(Str::random(8));

        $data['id_user'] = Auth::user()->id_user;

        Pasien::create($data);

        return redirect()
            ->route('pasien.dashboard')
            ->with('success', 'Data pasien berhasil didaftarkan.');
    }
}