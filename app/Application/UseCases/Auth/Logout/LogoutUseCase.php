<?php

namespace App\Application\UseCases\Auth\Logout;

use Illuminate\Support\Facades\Auth;

class LogoutUseCase
{
    public function execute(): void
    {
        if (Auth::check() == false) {
            throw new \Exception('You are not authorised');
        }

        auth()->user()->tokens()->delete();
    }
}