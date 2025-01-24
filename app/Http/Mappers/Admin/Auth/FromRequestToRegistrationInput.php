<?php

namespace App\Http\Mappers\Admin\Auth;

use App\Application\UseCases\Admin\Auth\Registration\RegistrationInputDTO;
use App\Http\Requests\Admin\Auth\RegistrationRequest;

class FromRequestToRegistrationInput
{
    public function map(RegistrationRequest $registrationRequest): RegistrationInputDTO
    {
        return new RegistrationInputDTO(
            $registrationRequest->validated('email'),
            $registrationRequest->validated('password'),
        );
    }
}