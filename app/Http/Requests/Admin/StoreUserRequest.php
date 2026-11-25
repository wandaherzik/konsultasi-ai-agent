<?php

namespace App\Http\Requests\admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Services\UserIdGenerator;


class StoreUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
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
                Rule::in([
                    'pasien',
                    'admin',
                    'dokter',
                    'kapus',
                ]),
            ],
        ];
    }

    public function attributes(): array
    {
        return [
            'nama' => 'nama lengkap',
            'username' => 'username',
            'password' => 'password',
            'role' => 'role pengguna',
        ];
    }
}