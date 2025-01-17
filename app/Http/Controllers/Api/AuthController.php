<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Application\UseCases\Auth\LoginUseCase;
use App\Http\Requests\Auth\RegistrationRequest;
use App\Http\Mappers\FromLoginRequestToLoginInput;
use App\Application\UseCases\Auth\RegistrationUseCase;
use App\Http\Mappers\FromRegistrationRequestToRegistrationInput;

class AuthController extends Controller
{
    public function __construct(
        private readonly RegistrationUseCase                        $registrationUseCase,
        private readonly LoginUseCase                               $loginUseCase,
        private readonly FromLoginRequestToLoginInput               $loginMapper,
        private readonly FromRegistrationRequestToRegistrationInput $registrationMapper, // TODO: prefix map
    )
    {
    }

    // TODO: swagger
    public function registration(RegistrationRequest $registrationRequest): JsonResponse
    {
        try {
            $message = $this->registrationUseCase->registration($this->registrationMapper->map($registrationRequest));

            return response()->json([
                'success' => true,
                'message' => $message
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'success' => false,
                'message' => $exception->getMessage(),
            ], 400);
        }
    }

    // TODO: swagger
    public function login(LoginRequest $loginRequest): JsonResponse
    {
        try {
            $token = $this->loginUseCase->login($this->loginMapper->map($loginRequest));

            return response()->json([
                'success' => true,
                'token' => $token,
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'success' => false,
                'message' => $exception->getMessage(),
            ], 400);
        }
    }
}
