<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Pasien;
use App\Models\Dokter;
use App\Models\Poli;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller
{
    /**
     * Dashboard Admin
     */
    public function index()
    {
        // =========================
        // DATA STATISTIK
        // =========================

        $totalUser = User::count();

        $totalPasien = Pasien::count();

        $totalDokter = Dokter::count();

        $totalPoli = Poli::count();


        // =========================
        // USER TERBARU
        // =========================

        $users = User::latest()
            ->paginate(10);


        // =========================
        // DASHBOARD
        // =========================

        return view(
            'admin.dashboard',
            compact(
                'users',
                'totalUser',
                'totalPasien',
                'totalDokter',
                'totalPoli'
            )
        );
    }


    /**
     * Form tambah user
     */
    public function create()
    {
        return view('admin.create');
    }


    /**
     * Simpan user
     */
    public function store(Request $request)
    {
        $validated = $request->validate([

            'nama' => [
                'required',
                'string',
                'max:100',
            ],

            'username' => [
                'required',
                'string',
                'max:50',
                'unique:users,username',
            ],

            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
            ],

            'role' => [
                'required',
                'in:admin,dokter,pasien,kapus',
            ],

        ]);


        $validated['id_user'] =
            $this->generateUserId();


        $validated['password'] =
            Hash::make(
                $validated['password']
            );


        User::create($validated);


        return redirect()
            ->route('admin.index')
            ->with(
                'success',
                'Pengguna berhasil ditambahkan.'
            );
    }


    /**
     * Form edit user
     */
    public function edit(User $user)
    {
        return view(
            'admin.edit',
            compact('user')
        );
    }


    /**
     * Update user
     */
    public function update(
        Request $request,
        User $user
    ) {

        $validated = $request->validate([

            'nama' => [
                'required',
                'string',
                'max:100',
            ],

            'username' => [
                'required',
                'string',
                'max:50',
                'unique:users,username,' .
                $user->id_user .
                ',id_user',
            ],

            'role' => [
                'required',
                'in:admin,dokter,pasien,kapus',
            ],

        ]);


        if ($request->filled('password')) {

            $request->validate([

                'password' => [
                    'string',
                    'min:8',
                    'confirmed',
                ],

            ]);


            $validated['password'] =
                Hash::make(
                    $request->password
                );
        }


        $user->update($validated);


        return redirect()
            ->route('admin.index')
            ->with(
                'success',
                'Pengguna berhasil diperbarui.'
            );
    }


    /**
     * Hapus user
     */
    public function destroy(User $user)
    {
        $user->delete();


        return redirect()
            ->route('admin.index')
            ->with(
                'success',
                'Pengguna berhasil dihapus.'
            );
    }


    /**
     * Generate ID User
     */
    private function generateUserId(): string
    {
        do {

            $id = 'USR' . str_pad(
                (string) random_int(
                    1,
                    99999999
                ),
                8,
                '0',
                STR_PAD_LEFT
            );

        } while (
            User::where(
                'id_user',
                $id
            )->exists()
        );


        return $id;
    }
}