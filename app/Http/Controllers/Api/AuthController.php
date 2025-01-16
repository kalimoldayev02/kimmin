<?php

namespace App\Http\Controllers\Api;

use App\Application\UseCases\Auth\RegistrationUseCase;
use App\Http\Mappers\FromRegistrationRequestToRegistrationInput;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Auth\LoginRequest;
use App\Application\UseCases\Auth\LoginUseCase;
use App\Http\Requests\Auth\RegistrationRequest;
use App\Http\Mappers\FromLoginRequestToLoginInput;

class AuthController extends Controller
{
    public function __construct(
        private RegistrationUseCase $registrationUseCase,
        private LoginUseCase $loginUseCase,
        private FromLoginRequestToLoginInput $loginMapper,
        private FromRegistrationRequestToRegistrationInput $registrationMapper, // TODO: prefix map
    )
    {
    }

    // TODO: swagger
    public function registration(RegistrationRequest $registrationRequest): JsonResponse
    {

        // TODO: вынести в UseCase

        if (Auth::check()) {
            return response()->json([
                'success' => 'false',
                'message' => 'You are authenticated'
            ]);
        }

        User::create($registrationRequest->validated());

        return response()->json([
            'success' => true,
            'message' => 'User created'
        ]);
    }

    // TODO: swagger
    public function login(LoginRequest $loginRequest): array
    {
        try {
            $token = $this->loginUseCase->login($this->loginMapper->map($loginRequest));

            return [
                'success' => true,
                'token' => $token,
            ];
        } catch (\Exception $exception) {
            return response()->json([
                'success' => false,
                'message' => $exception->getMessage(),
            ]);
        }
    }
}
