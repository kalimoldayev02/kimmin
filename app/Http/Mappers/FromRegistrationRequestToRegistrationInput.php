<?php

namespace App\Http\Mappers;

use App\Application\DTO\RegistrationInputDTO;
use App\Http\Requests\Auth\RegistrationRequest;

class FromRegistrationRequestToRegistrationInput
{
    public function map(RegistrationRequest $registrationRequest): RegistrationInputDTO
    {
        return new RegistrationInputDTO(
            $registrationRequest->validated('email'),
            $registrationRequest->validated('password'),
        );
    }
}