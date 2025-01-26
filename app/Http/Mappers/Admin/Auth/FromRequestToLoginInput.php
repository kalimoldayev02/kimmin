<?php

namespace App\Http\Mappers\Admin\Auth;

use App\Application\UseCases\Admin\Auth\Login\LoginInputDTO;
use App\Http\Requests\Admin\Auth\LoginRequest;

class FromRequestToLoginInput
{
    public function map(LoginRequest $loginRequest): LoginInputDTO
    {
        return new LoginInputDTO(
            $loginRequest->validated('email'),
            $loginRequest->validated('password'),
        );
    }
}