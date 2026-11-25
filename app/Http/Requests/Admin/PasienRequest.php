<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class PasienRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id_user' => [
                'required',
                'exists:users,id_user',
            ],

            'nama_pasien' => [
                'required',
                'string',
                'max:100',
            ],

            'nik' => [
                'required',
                'digits:16',
                'unique:pasien,nik,' .
                    $this->route('pasien') .
                    ',id_pasien',
            ],

            'jenis_kelamin' => [
                'required',
                'in:Laki-laki,Perempuan',
            ],

            'tanggal_lahir' => [
                'required',
                'date',
                'before:today',
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
        ];
    }

    public function messages(): array
    {
        return [
            'id_user.required' =>
                'Akun pasien wajib dipilih.',

            'id_user.exists' =>
                'Akun pasien tidak ditemukan.',

            'nama_pasien.required' =>
                'Nama pasien wajib diisi.',

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

            'tanggal_lahir.before' =>
                'Tanggal lahir harus merupakan tanggal yang sudah berlalu.',

            'no_bpjs.max' =>
                'Nomor BPJS maksimal 25 karakter.',

            'alamat.required' =>
                'Alamat wajib diisi.',

            'no_telepon.required' =>
                'Nomor telepon wajib diisi.',

            'no_telepon.max' =>
                'Nomor telepon maksimal 15 karakter.',
        ];
    }
}

