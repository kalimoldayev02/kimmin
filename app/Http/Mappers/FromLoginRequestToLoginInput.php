<?php

namespace App\Http\Mappers;

use App\Application\UseCases\Auth\Login\LoginInputDTO;
use App\Http\Requests\Auth\LoginRequest;

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