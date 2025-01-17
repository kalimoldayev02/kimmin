<?php

namespace App\Http\Controllers\Api;

use OpenApi\Attributes as OA;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\Auth\LoginRequest;
use Symfony\Component\HttpFoundation\Response;
use App\Application\UseCases\Auth\LoginUseCase;
use App\Http\Requests\Auth\RegistrationRequest;
use App\Http\Mappers\FromLoginRequestToLoginInput;
use App\Application\UseCases\Auth\RegistrationUseCase;
use App\Http\Mappers\FromRegistrationRequestToRegistrationInput;

class AuthController extends BaseController
{
    #[OA\Post(
        path: '/api/admin/registration',
        summary: 'Регистрация пользователя для админ панели',
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: 'email', description: 'Email', type: 'string', example: 'test@test.com'),
                    new OA\Property(property: 'password', description: 'Пароль', type: 'string', example: '123'),
                ]
            )
        ),
        tags: ['Admin'],
        responses: [
            new OA\Response(
                response: Response::HTTP_OK,
                description: 'Successful operation',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'status', description: 'Статус', type: 'boolean', example: true),
                        new OA\Property(property: 'message', description: 'Сообщение', type: "string", example: 'You are authenticated'),
                    ]
                )
            ),
            new OA\Response(
                response: Response::HTTP_BAD_REQUEST,
                description: 'Bad Request',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'status', description: 'Operation\'s status', type: 'boolean', example: false),
                        new OA\Property(property: 'data', properties: [], type: 'object', example: []),
                        new OA\Property(property: 'errors', type: 'array', items: new OA\Items(type: 'string', example: "Houston, we have a problem"))
                    ]
                )
            ),
        ]
    )]
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
