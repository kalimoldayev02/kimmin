<?php

namespace App\Application\UseCases\Auth;

use Illuminate\Support\Facades\Auth;
use App\Application\DTOs\LoginInputDTO;
use App\Repositories\User\UserRepository;

class LoginUseCase
{
    public function __construct(private UserRepository $userRepository)
    {
    }

    /**
     * @throws \Exception
     */
    public function login(LoginInputDTO $loginInput): string
    {
        if ($this->userRepository->hasUserByEmail($loginInput->email) == false) {
            throw new \Exception('User not found');
        }

        if (Auth::attempt(['email' => $loginInput->email, 'password' => $loginInput->password]) == false) {
            throw new \Exception('Your data does not match');
        }

        $token = Auth::user()->createToken('admin_token', ['user']);

        return $token->plainTextToken;
    }
}