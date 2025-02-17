<?php

namespace App\Application\UseCases\Admin\Auth\Registration;

use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;

class RegistrationUseCase
{
    /**
     * @throws Exception
     */
    public function execute(RegistrationInputDTO $registrationInput): void
    {
        if (Auth::check()) {
            throw new Exception(__('You are authenticated'));
        }

        User::create(['email' => $registrationInput->email, 'password' => $registrationInput->password]);
    }
}