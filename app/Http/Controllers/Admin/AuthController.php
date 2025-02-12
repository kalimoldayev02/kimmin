<?php

namespace App\Http\Controllers\Admin;

use App\Application\UseCases\Admin\Auth\Login\LoginUseCase;
use App\Application\UseCases\Admin\Auth\Logout\LogoutUseCase;
use App\Application\UseCases\Admin\Auth\Registration\RegistrationUseCase;
use App\Http\Controllers\Controller;
use App\Http\Mappers\Admin\Auth\FromRequestToLoginInput as LoginMapper;
use App\Http\Mappers\Admin\Auth\FromRequestToRegistrationInput as RegistrationMapper;
use App\Http\Requests\Admin\Auth\LoginRequest;
use App\Http\Requests\Admin\Auth\RegistrationRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\Response;

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
        tags: ['Admin-Auth'],
        responses: [
            new OA\Response(
                response: Response::HTTP_OK,
                description: 'Successful operation',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'status', description: 'Статус', type: 'boolean', example: true),
                        new OA\Property(property: 'message', description: 'Сообщение', type: 'string', example: 'User has been successfully created'),
                    ]
                )
            ),
            new OA\Response(
                response: Response::HTTP_BAD_REQUEST,
                description: 'Bad Request',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'status', description: 'Operation\'s status', type: 'boolean', example: false),
                        new OA\Property(property: 'message', description: 'Сообщение', type: 'string', example: 'The given data was invalid'),
                        new OA\Property(property: 'errors', properties: [
                            new OA\Property(property: 'email', type: 'array', items: new OA\Items(type: 'string', example: 'Houston, we have a problem'))
                        ], type: 'object'),
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
            $registrationUseCase->execute($registrationMapper->map($registrationRequest));

            return $this->getResponse(true, __('User has been successfully created'));
        } catch (\Exception $exception) {
            return $this->getResponse(false, $exception->getMessage());
        }
    }

    #[OA\Post(
        path: '/api/admin/login',
        summary: 'Авторизация пользователя для админ панели',
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: 'email', description: 'Email', type: 'string', example: 'test@test.com'),
                    new OA\Property(property: 'password', description: 'Пароль', type: 'string', example: '123'),
                ]
            )
        ),
        tags: ['Admin-Auth'],
        responses: [
            new OA\Response(
                response: Response::HTTP_OK,
                description: 'Successful operation',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'status', description: 'Статус', type: 'boolean', example: true),
                        new OA\Property(property: 'message', description: 'Сообщение', type: 'string', example: 'You have successfully logged in'),
                        new OA\Property(property: 'data', properties: [new OA\Property(property: 'token', type: 'string', example: '...')], type: 'object'),
                    ]
                )
            ),
            new OA\Response(
                response: Response::HTTP_BAD_REQUEST,
                description: 'Bad Request',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'status', description: 'Operation\'s status', type: 'boolean', example: false),
                        new OA\Property(property: 'message', description: 'Сообщение', type: 'string', example: 'The email field is required'),
                        new OA\Property(property: 'errors', properties: [
                            new OA\Property(property: 'email', type: 'array', items: new OA\Items(type: 'string', example: 'Houston, we have a problem'))
                        ], type: 'object'),
                    ]
                )
            ),
        ]
    )]
    public function login(
        LoginRequest $loginRequest,
        LoginUseCase $loginUseCase,
        LoginMapper  $loginMapper,
    ): JsonResponse
    {
        try {
            $responseData['token'] = $loginUseCase->execute($loginMapper->map($loginRequest));

            return $this->getResponse(true, __('You have successfully logged in'), $responseData);
        } catch (\Exception $exception) {
            return $this->getResponse(false, $exception->getMessage());
        }
    }

    #[OA\Post(
        path: '/api/admin/logout',
        summary: 'Выход пользователя из админ панели',
        tags: ['Admin-Auth'],
        responses: [
            new OA\Response(
                response: Response::HTTP_OK,
                description: 'Successful operation',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'status', description: 'Статус', type: 'boolean', example: true),
                        new OA\Property(property: 'message', description: 'Сообщение', type: 'string', example: 'You have successfully logged out'),
                    ]
                )
            ),
            new OA\Response(
                response: Response::HTTP_BAD_REQUEST,
                description: 'Bad Request',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'status', description: 'Operation\'s status', type: 'boolean', example: false),
                        new OA\Property(property: 'message', description: 'Сообщение', type: 'string', example: 'Houston, we have a problem'),
                    ]
                )
            ),
        ]
    )]
    public function logout(LogoutUseCase $logoutUseCase): JsonResponse
    {
        try {
            $logoutUseCase->execute();

            return $this->getResponse(true, __('You have successfully logged out'));
        } catch (\Exception $exception) {
            return $this->getResponse(false, $exception->getMessage());
        }
    }

    #[OA\Get(
        path: '/api/admin/check',
        summary: 'Проверка пользователя',
        tags: ['Admin-Auth'],
        responses: [
            new OA\Response(
                response: Response::HTTP_OK,
                description: 'Successful operation',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'status', description: 'Статус', type: 'boolean', example: true),
                        new OA\Property(property: 'message', description: 'Сообщение', type: 'string', example: 'You are authorised'),
                    ]
                )
            ),
            new OA\Response(
                response: Response::HTTP_BAD_REQUEST,
                description: 'Bad Request',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'status', description: 'Operation\'s status', type: 'boolean', example: false),
                        new OA\Property(property: 'message', description: 'Сообщение', type: 'string', example: 'You are not authorised'),
                    ]
                )
            ),
        ]
    )]
    public function check(): JsonResponse
    {
        try {
            if (Auth::check() == false) {
                throw new \Exception(__('You are not authorised'));
            }

            return $this->getResponse(true, __('You are authorised'));
        } catch (\Exception $exception) {
            return $this->getResponse(false, $exception->getMessage());
        }
    }
}
