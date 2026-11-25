<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dokter;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DokterController extends Controller
{
    /**
     * Menampilkan daftar dokter.
     */
    public function index()
    {
        $dokters = Dokter::with('user')
            ->latest()
            ->paginate(10);

        return view('admin.dokter.index', compact('dokters'));
    }

    /**
     * Menampilkan form tambah dokter.
     */
    public function create()
    {
        $users = User::where('role', 'dokter')
            ->whereDoesntHave('dokter')
            ->orderBy('nama')
            ->get();

        return view('admin.dokter.create', compact('users'));
    }

    /**
     * Menyimpan dokter.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_user' => [
                'required',
                'exists:users,id_user',
                'unique:dokter,id_user',
            ],
            'nama_dokter' => [
                'required',
                'string',
                'max:100',
            ],
            'spesialisasi_dokter' => [
                'required',
                'string',
                'max:100',
            ],
        ]);

        $validated['id_dokter'] = 'DR-' . strtoupper(
            Str::random(8)
        );

        Dokter::create($validated);

        return redirect()
            ->route('admin.dokter.index')
            ->with('success', 'Data dokter berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail dokter.
     */
    public function show(string $id)
    {
        $dokter = Dokter::with('user')
            ->findOrFail($id);

        return view('admin.dokter.show', compact('dokter'));
    }

    /**
     * Form edit dokter.
     */
    public function edit(string $id)
    {
        $dokter = Dokter::findOrFail($id);

        $users = User::where('role', 'dokter')
            ->where(function ($query) use ($dokter) {
                $query->whereDoesntHave('dokter')
                    ->orWhere('id_user', $dokter->id_user);
            })
            ->orderBy('nama')
            ->get();

        return view(
            'admin.dokter.edit',
            compact('dokter', 'users')
        );
    }

    /**
     * Update dokter.
     */
    public function update(Request $request, string $id)
    {
        $dokter = Dokter::findOrFail($id);

        $validated = $request->validate([
            'id_user' => [
                'required',
                'exists:users,id_user',
                'unique:dokter,id_user,' . $dokter->id_dokter . ',id_dokter',
            ],
            'nama_dokter' => [
                'required',
                'string',
                'max:100',
            ],
            'spesialisasi_dokter' => [
                'required',
                'string',
                'max:100',
            ],
        ]);

        $dokter->update($validated);

        return redirect()
            ->route('admin.dokter.index')
            ->with('success', 'Data dokter berhasil diperbarui.');
    }

    /**
     * Hapus dokter.
     */
    public function destroy(string $id)
    {
        $dokter = Dokter::findOrFail($id);

        $dokter->delete();

        return redirect()
            ->route('admin.dokter.index')
            ->with('success', 'Data dokter berhasil dihapus.');
    }
}