<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Str;

class UserIdGenerator
{
    public function generate(): string
    {
        do {
            $id = 'USR-' . strtoupper(Str::random(8));
        } while (User::where('id_user', $id)->exists());

        return $id;
    }
}