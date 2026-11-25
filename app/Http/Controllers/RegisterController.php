<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\Pasien;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    /**
     * Menampilkan halaman registrasi pasien.
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Memproses registrasi pasien.
     */
    public function store(RegisterRequest $request)
    {
        DB::transaction(function () use ($request) {

            /*
             * Generate ID User.
             *
             * Sesuaikan dengan generator ID yang kita gunakan
             * agar panjang maksimal 11 karakter.
             */
            $idUser = $this->generateUserId();

            /*
             * Membuat akun user.
             */
            $user = User::create([
                'id_user' => $idUser,
                'nama' => $request->nama_pasien,
                'username' => $request->username,
                'password' => Hash::make($request->password),
                'role' => 'pasien',
            ]);

            /*
             * Generate ID Pasien.
             */
            $idPasien = $this->generatePasienId();

            /*
             * Membuat data pasien.
             */
            Pasien::create([
                'id_pasien' => $idPasien,
                'id_user' => $user->id_user,
                'nama_pasien' => $request->nama_pasien,
                'nik' => $request->nik,
                'jenis_kelamin' => $request->jenis_kelamin,
                'tanggal_lahir' => $request->tanggal_lahir,
                'no_bpjs' => $request->no_bpjs,
                'alamat' => $request->alamat,
                'no_telepon' => $request->no_telepon,
            ]);
        });

        return redirect()
            ->route('login')
            ->with(
                'success',
                'Pendaftaran berhasil. Silakan login menggunakan akun Anda.'
            );
    }

    /**
     * Generate ID User maksimal 11 karakter.
     */
    private function generateUserId(): string
    {
        do {
            $id = 'U' . strtoupper(
                substr(
                    bin2hex(random_bytes(5)),
                    0,
                    10
                )
            );
        } while (User::where('id_user', $id)->exists());

        return $id;
    }

    /**
     * Generate ID Pasien maksimal 11 karakter.
     */
    private function generatePasienId(): string
    {
        do {
            $id = 'P' . strtoupper(
                substr(
                    bin2hex(random_bytes(5)),
                    0,
                    10
                )
            );
        } while (Pasien::where('id_pasien', $id)->exists());

        return $id;
    }
}