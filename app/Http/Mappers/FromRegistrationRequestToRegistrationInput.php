<?php

namespace App\Http\Mappers;

use App\Application\DTOs\LoginInputDTO;
use App\Http\Requests\Auth\RegistrationRequest;

class FromRegistrationRequestToRegistrationInput
{
    public function map(RegistrationRequest $registrationRequest): LoginInputDTO
    {
        return new LoginInputDTO(
            $registrationRequest->validated('email'),
            $registrationRequest->validated('password'),
        );
    }
}