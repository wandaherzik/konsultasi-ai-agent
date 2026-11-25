<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class JadwalDokterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id_dokter' => [
                'required',
                'exists:dokter,id_dokter',
            ],

            'id_poli' => [
                'required',
                'exists:poli,id_poli',
            ],

            'hari' => [
                'required',
                Rule::in([
                    'Senin',
                    'Selasa',
                    'Rabu',
                    'Kamis',
                    'Jumat',
                    'Sabtu',
                ]),
            ],

            'jam_buka' => [
                'required',
                'date_format:H:i',
            ],

            'jam_tutup' => [
                'required',
                'date_format:H:i',
                'after:jam_buka',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'id_dokter.required' => 'Dokter wajib dipilih.',
            'id_dokter.exists' => 'Dokter tidak ditemukan.',

            'id_poli.required' => 'Poli wajib dipilih.',
            'id_poli.exists' => 'Poli tidak ditemukan.',

            'hari.required' => 'Hari praktik wajib dipilih.',
            'hari.in' => 'Hari praktik tidak valid.',

            'jam_buka.required' => 'Jam buka wajib diisi.',
            'jam_buka.date_format' => 'Format jam buka tidak valid.',

            'jam_tutup.required' => 'Jam tutup wajib diisi.',
            'jam_tutup.date_format' => 'Format jam tutup tidak valid.',
            'jam_tutup.after' => 'Jam tutup harus lebih besar dari jam buka.',
        ];
    }
}