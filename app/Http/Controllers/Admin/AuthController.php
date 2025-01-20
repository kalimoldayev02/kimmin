<?php

namespace App\Http\Controllers\Admin;

use App\Application\UseCases\Admin\Auth\Login\LoginUseCase;
use App\Application\UseCases\Admin\Auth\Logout\LogoutUseCase;
use App\Application\UseCases\Admin\Auth\Registration\RegistrationUseCase;
use App\Http\Controllers\Controller;
use App\Http\Mappers\FromLoginRequestToLoginInput as LoginMapper;
use App\Http\Mappers\FromRegistrationRequestToRegistrationInput as RegistrationMapper;
use App\Http\Requests\Admin\Auth\LoginRequest;
use App\Http\Requests\Admin\Auth\RegistrationRequest;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\Response;
use function response;

class AuthController extends Controller
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
        RegistrationRequest $registrationRequest,
        RegistrationUseCase $registrationUseCase,
        RegistrationMapper  $registrationMapper,
    ): JsonResponse
    {
        try {
            $message = $registrationUseCase->execute($registrationMapper->map($registrationRequest));

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
        LoginRequest $loginRequest,
        LoginUseCase $loginUseCase,
        LoginMapper  $loginMapper,
    ): JsonResponse
    {
        try {
            $token = $loginUseCase->execute($loginMapper->map($loginRequest));

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

    // TODO: swagger
    public function logout(LogoutUseCase $logoutUseCase): JsonResponse
    {
        try {
            $logoutUseCase->execute();

            return response()->json([
                'success' => true,
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'success' => false,
                'message' => $exception->getMessage(),
            ], 400);
        }
    }
}
