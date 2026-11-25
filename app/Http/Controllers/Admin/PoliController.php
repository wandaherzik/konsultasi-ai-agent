<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Poli;
use App\Services\PoliIdGenerator;
use Illuminate\Http\Request;

class PoliController extends Controller
{
    public function index()
    {
        $polis = Poli::latest()->paginate(10);

        return view('admin.poli.index', compact('polis'));
    }

    public function create()
    {
        return view('admin.poli.create');
    }

    public function store(
        Request $request,
        PoliIdGenerator $idGenerator
    ) {
        $validated = $request->validate([
            'nama_poli' => 'required|string|max:100',
            'deskripsi' => 'required|string',
            'kapasitas_harian' => 'required|integer|min:1',
        ]);

        Poli::create([
            'id_poli' => $idGenerator->generate(),
            'nama_poli' => $validated['nama_poli'],
            'deskripsi' => $validated['deskripsi'],
            'kapasitas_harian' => $validated['kapasitas_harian'],
        ]);

        return redirect()
            ->route('admin.poli.index')
            ->with('success', 'Poli berhasil ditambahkan.');
    }

    public function edit(string $id_poli)
    {
        $poli = Poli::findOrFail($id_poli);

        return view('admin.poli.edit', compact('poli'));
    }

    public function update(
        Request $request,
        string $id_poli
    ) {
        $poli = Poli::findOrFail($id_poli);

        $validated = $request->validate([
            'nama_poli' => 'required|string|max:100',
            'deskripsi' => 'required|string',
            'kapasitas_harian' => 'required|integer|min:1',
        ]);

        $poli->update($validated);

        return redirect()
            ->route('admin.poli.index')
            ->with('success', 'Data poli berhasil diperbarui.');
    }

    public function destroy(string $id_poli)
    {
        $poli = Poli::findOrFail($id_poli);

        $poli->delete();

        return redirect()
            ->route('admin.poli.index')
            ->with('success', 'Poli berhasil dihapus.');
    }
}