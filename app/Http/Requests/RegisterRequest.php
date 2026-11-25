<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // =========================
            // DATA PASIEN
            // =========================

            'nama_pasien' => [
                'required',
                'string',
                'max:100',
            ],

            'nik' => [
                'required',
                'digits:16',
                'unique:pasien,nik',
            ],

            'jenis_kelamin' => [
                'required',
                'in:Laki-laki,Perempuan',
            ],

            'tanggal_lahir' => [
                'required',
                'date',
            ],

            'no_bpjs' => [
                'nullable',
                'string',
                'max:25',
            ],

            'alamat' => [
                'required',
                'string',
            ],

            'no_telepon' => [
                'required',
                'string',
                'max:15',
            ],

            // =========================
            // DATA AKUN
            // =========================

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
        ];
    }

    public function messages(): array
    {
        return [
            'nama_pasien.required' =>
                'Nama pasien wajib diisi.',

            'nama_pasien.max' =>
                'Nama pasien maksimal 100 karakter.',

            'nik.required' =>
                'NIK wajib diisi.',

            'nik.digits' =>
                'NIK harus terdiri dari 16 digit.',

            'nik.unique' =>
                'NIK sudah terdaftar.',

            'jenis_kelamin.required' =>
                'Jenis kelamin wajib dipilih.',

            'jenis_kelamin.in' =>
                'Jenis kelamin tidak valid.',

            'tanggal_lahir.required' =>
                'Tanggal lahir wajib diisi.',

            'tanggal_lahir.date' =>
                'Format tanggal lahir tidak valid.',

            'no_bpjs.max' =>
                'Nomor BPJS maksimal 25 karakter.',

            'alamat.required' =>
                'Alamat wajib diisi.',

            'no_telepon.required' =>
                'Nomor telepon wajib diisi.',

            'no_telepon.max' =>
                'Nomor telepon maksimal 15 karakter.',

            'username.required' =>
                'Username wajib diisi.',

            'username.unique' =>
                'Username sudah digunakan.',

            'password.required' =>
                'Password wajib diisi.',

            'password.min' =>
                'Password minimal 8 karakter.',

            'password.confirmed' =>
                'Konfirmasi password tidak sesuai.',
        ];
    }
}