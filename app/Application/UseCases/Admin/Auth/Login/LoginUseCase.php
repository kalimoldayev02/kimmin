<?php

namespace App\Application\UseCases\Admin\Auth\Login;

use App\Repositories\User\UserRepository;
use Illuminate\Support\Facades\Auth;

class LoginUseCase
{
    public function __construct(private UserRepository $userRepository)
    {
    }

    /**
     * @throws \Exception
     */
    public function execute(LoginInputDTO $loginInput): string
    {
        if ($this->userRepository->hasUserByEmail($loginInput->email) == false) {
            throw new \Exception(__('User not found'));
        }

        if (Auth::attempt(['email' => $loginInput->email, 'password' => $loginInput->password]) == false) {
            throw new \Exception(__('Your data does not match'));
        }

        $token = Auth::user()->createToken('access_token', ['role:admin']);

        return $token->plainTextToken;
    }
}