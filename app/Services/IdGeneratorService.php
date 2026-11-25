<?php

namespace App\Services;

use App\Models\User;

class UserIdGenerator
{
    public function generate(): string
    {
        $lastUser = User::query()
            ->orderByDesc('id_user')
            ->first();

        if (!$lastUser) {
            return 'USR00000001';
        }

        $lastNumber = (int) substr($lastUser->id_user, 3);

        $nextNumber = $lastNumber + 1;

        return 'USR' . str_pad(
            $nextNumber,
            8,
            '0',
            STR_PAD_LEFT
        );
    }
}