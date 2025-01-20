<?php

namespace App\Repositories\User;

use App\Models\User;

class UserRepository
{
    public function hasUserByEmail(string $email): bool
    {
        return User::query()->where('email', trim($email))->exists();
    }
}