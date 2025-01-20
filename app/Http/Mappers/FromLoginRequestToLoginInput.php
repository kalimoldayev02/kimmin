<?php

namespace App\Http\Mappers;

use App\Application\UseCases\Admin\Auth\Login\LoginInputDTO;
use App\Http\Requests\Admin\Auth\LoginRequest;

class FromLoginRequestToLoginInput
{
    public function map(LoginRequest $loginRequest): LoginInputDTO
    {
        return new LoginInputDTO(
            $loginRequest->validated('email'),
            $loginRequest->validated('password'),
        );
    }
}