<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\admin\PasienRequest;
use App\Models\Pasien;
use App\Models\User;
use App\Services\UserIdGenerator;


class PasienController extends Controller
{
    public function index()
    {
        $pasiens = Pasien::with('user')
            ->latest()
            ->paginate(10);

        return view('admin.pasien.index', compact('pasiens'));
    }

    public function create()
    {
        $users = User::where('role', 'pasien')
            ->orderBy('nama')
            ->get();

        return view('admin.pasien.create', compact('users'));
    }

    public function store(
        PasienRequest $request,
        UserIdGenerator $idGenerator
    ) {
        Pasien::create([
            'id_pasien' => $idGenerator->generate('PSN'),
            'id_user' => $request->id_user,
            'nama_pasien' => $request->nama_pasien,
            'nik' => $request->nik,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tanggal_lahir' => $request->tanggal_lahir,
            'no_bpjs' => $request->no_bpjs,
            'alamat' => $request->alamat,
            'no_telepon' => $request->no_telepon,
        ]);

        return redirect()
            ->route('admin.pasien.index')
            ->with('success', 'Data pasien berhasil ditambahkan.');
    }

    public function edit(string $id_pasien)
    {
        $pasien = Pasien::findOrFail($id_pasien);

        $users = User::where('role', 'pasien')
            ->orderBy('nama')
            ->get();

        return view('admin.pasien.edit', compact(
            'pasien',
            'users'
        ));
    }

    public function update(
        PasienRequest $request,
        string $id_pasien
    ) {
        $pasien = Pasien::findOrFail($id_pasien);

        $pasien->update([
            'id_user' => $request->id_user,
            'nama_pasien' => $request->nama_pasien,
            'nik' => $request->nik,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tanggal_lahir' => $request->tanggal_lahir,
            'no_bpjs' => $request->no_bpjs,
            'alamat' => $request->alamat,
            'no_telepon' => $request->no_telepon,
        ]);

        return redirect()
            ->route('admin.pasien.index')
            ->with('success', 'Data pasien berhasil diperbarui.');
    }

    public function destroy(string $id_pasien)
    {
        $pasien = Pasien::findOrFail($id_pasien);

        $pasien->delete();

        return redirect()
            ->route('admin.pasien.index')
            ->with('success', 'Data pasien berhasil dihapus.');
    }

        /**
     * Menampilkan detail pasien.
     */
    public function show(string $id)
    {
        $pasien = Pasien::with('user')
            ->findOrFail($id);

        return view('admin.pasien.show', compact('pasien'));
    }
}