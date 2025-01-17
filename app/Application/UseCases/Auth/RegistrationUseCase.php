<?php

namespace App\Application\UseCases\Auth;

use Exception;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Application\DTO\RegistrationInputDTO;

class RegistrationUseCase
{
    /**
     * @throws Exception
     */
    public function execute(RegistrationInputDTO $registrationInput): string
    {
        if (Auth::check()) {
            throw new Exception('You are authenticated');
        }

        User::create(['email' => $registrationInput->email, 'password' => $registrationInput->password]);

        return 'User created';
    }
}