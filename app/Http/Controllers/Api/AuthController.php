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
    // TODO: swagger
    public function registration(
        RegistrationRequest                        $registrationRequest,
        RegistrationUseCase                        $useCase,
        FromRegistrationRequestToRegistrationInput $mapper,
    ): JsonResponse
    {
        try {
            $message = $useCase->execute($mapper->map($registrationRequest));

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
    public function login(
        LoginRequest                 $loginRequest,
        LoginUseCase                 $useCase,
        FromLoginRequestToLoginInput $mapper,
    ): JsonResponse
    {
        try {
            $token = $useCase->execute($mapper->map($loginRequest));

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
