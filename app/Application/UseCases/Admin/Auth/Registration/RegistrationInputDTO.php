<?php

namespace App\Application\UseCases\Admin\Auth\Registration;

class RegistrationInputDTO
{
    public function __construct(
        public string $email,
        public string $password,
    )
    {
    }
}